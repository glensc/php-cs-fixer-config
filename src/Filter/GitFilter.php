<?php

namespace glen\PhpCsFixerConfig\Filter;

use glen\PhpCsFixerConfig\ProcessRunner;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Setup Finder to inspect only files that are present in Git index.
 *
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/2214
 */
class GitFilter implements FilterInterface {
	/** @var string */
	private $dir;

	public function __construct($dir) {
		$this->dir = $dir;
	}

	/**
	 * {@inheritdoc}
	 */
	public function apply(Finder $finder) {
		$finder->in($this->dir);

		$files = $this->getGitFiles();

		// this filter would accept only files that are present in Git
		$finder->filter(function (SplFileInfo $file) use (&$files) {
			return array_search($file->getRelativePathname(), $files, true);
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
			$file = str_replace('/', DIRECTORY_SEPARATOR, $file);
		});

		return $files;
	}
}
