<?php

namespace ED\CS\Config\Helper;

use ED\CS\Config\ProcessRunner;
use RuntimeException;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\CS\Finder\DefaultFinder;
use Symfony\CS\FinderInterface;

class GitHelper {
	/**
	 * @var DefaultFinder|FinderInterface
	 */
	private $finder;

	/**
	 * GitHelper constructor.
	 *
	 * @param FinderInterface|DefaultFinder $finder
	 */
	public function __construct($finder) {
		$this->finder = $finder;
	}

	/**
	 * Setup Finder to inspect only files that are present in Git index.
	 *
	 * @link https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/2214
	 */
	public function addGitFilter() {
		try {
			$project_dir = ProcessRunner::run("git rev-parse --show-toplevel");
		} catch (ProcessFailedException $e) {
			throw new RuntimeException("Unable to get project root dir: " . $e->getMessage());
		}

		if (!$project_dir) {
			return;
		}
		$this->finder->in($project_dir);

		$files = explode("\n", ProcessRunner::run("git ls-files"));

		// this filter would accept only files that are present in Git
		$this->finder->filter(function (SplFileInfo $file) use (&$files) {
			$key = array_search($file->getRelativePathname(), $files);

			return $key;
		});
	}
}