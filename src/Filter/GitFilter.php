<?php

namespace ED\CS\Config\Filter;

use ED\CS\Config\ProcessRunner;
use RuntimeException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Setup Finder to inspect only files that are present in Git index.
 *
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/2214
 */
class GitFilter implements FilterInterface {
	/**
	 * {@inheritdoc}
	 */
	public function apply(Finder $finder) {
		try {
			$projectDir = ProcessRunner::run('git rev-parse --show-toplevel');
		} catch (ProcessFailedException $e) {
			throw new RuntimeException('Unable to get project root dir: ' . $e->getMessage());
		}

		if (!$projectDir) {
			return;
		}

		// ran via realpath to canonicalize path for windows
		$absPath = realpath($projectDir);
		if (!$absPath) {
			throw new RuntimeException("Unable to resolve path: $projectDir");
		}

		$finder->in($absPath);

		$files = $this->getGitFiles();

		// this filter would accept only files that are present in Git
		$finder->filter(function (SplFileInfo $file) use (&$files) {
			$key = array_search($file->getRelativePathname(), $files);

			return $key;
		});
	}

	/**
	 * Get listing of files present in git index.
	 *
	 * @return array
	 */
	private function getGitFiles() {
		$files = explode("\n", ProcessRunner::run('git ls-files'));

		if (DIRECTORY_SEPARATOR === '\\') {
			$files = $this->unixPathsToWindowsPaths($files);
		}

		return $files;
	}

	/**
	 * Convert path separators from '/' to '\\'
	 *
	 * @param string[] $files
	 * @return string[]
	 */
	private function unixPathsToWindowsPaths($files) {
		array_walk($files, function (&$file) {
			$file = strtr($file, '/', DIRECTORY_SEPARATOR);
		});

		return $files;
	}
}
