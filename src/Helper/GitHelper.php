<?php

namespace ED\CS\Config\Helper;

use RuntimeException;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
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
			$project_dir = $this->getCommandOutput("git rev-parse --show-toplevel");
		} catch (ProcessFailedException $e) {
			throw new RuntimeException("Unable to get project root dir: " . $e->getMessage());
		}

		if (!$project_dir) {
			return;
		}
		$this->finder->in($project_dir);

		$files = explode("\n", $this->getCommandOutput("git ls-files"));

		// this filter would accept only files that are present in Git
		$this->finder->filter(function (SplFileInfo $file) use (&$files) {
			$key = array_search($file->getRelativePathname(), $files);

			return $key;
		});
	}

	/**
	 * DRY wrapper to run program and capture it's output using Symfony Process Component
	 *
	 * @param string $command
	 * @return string
	 */
	private function getCommandOutput($command) {
		$process = new Process($command);
		$process->mustRun();

		$output = $process->getOutput();

		// omit the final newline from output
		return rtrim($output, PHP_EOL);
	}
}