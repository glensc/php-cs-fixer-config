<?php

namespace ED\CS\Config\Filter;

use ED\CS\Config\ProcessRunner;
use RuntimeException;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Setup Finder to inspect only files that are present in Git index.
 *
 * @link https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/2214
 */
class GitFilter implements FilterInterface {
	/**
	 * @param \Symfony\CS\Finder\DefaultFinder|\Symfony\CS\FinderInterface|\Traversable $finder
	 */
	public function apply($finder) {
		try {
			$project_dir = ProcessRunner::run("git rev-parse --show-toplevel");
		} catch (ProcessFailedException $e) {
			throw new RuntimeException("Unable to get project root dir: " . $e->getMessage());
		}

		if (!$project_dir) {
			return;
		}
		$finder->in($project_dir);

		$files = explode("\n", ProcessRunner::run("git ls-files"));

		// this filter would accept only files that are present in Git
		$finder->filter(function (SplFileInfo $file) use (&$files) {
			$key = array_search($file->getRelativePathname(), $files);

			return $key;
		});
	}
}