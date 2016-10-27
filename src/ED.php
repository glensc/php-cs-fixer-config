<?php

namespace ED\CS\Config;

use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\CS\Config\Config;
use Symfony\CS\Finder\DefaultFinder;
use Symfony\CS\FinderInterface;
use Symfony\CS\FixerInterface;

class ED extends Config {
	protected $usingCache = false;

	public function __construct() {
		parent::__construct('ED', 'The configuration for ED PHP applications');

		$this->level = FixerInterface::NONE_LEVEL;
		$this->fixers = $this->getRules();

		$finder = $this->getFinder();

		$this->setupGit($finder);

		// revert *.xml from DefaultFinder
		$finder
			->notPath('{^\.idea/.*\.xml$}');

		// because php-cs-fixer maintainers are idiots
		// https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/1027
		$finder
			->ignoreDotFiles(false)
			->name('.php_cs');
	}

	/**
	 * Setup Finder to inspect only files that are present in Git index.
	 *
	 * Will skip this process silently if the repository is not in git repo.
	 *
	 * @link https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/2214
	 * @param FinderInterface|DefaultFinder $finder
	 */
	private function setupGit($finder) {
		try {
			$project_dir = $this->getCommandOutput("git rev-parse --show-toplevel");
		} catch (ProcessFailedException $e) {
			return;
		}

		if (!$project_dir) {
			return;
		}
		$finder->in($project_dir);

		$files = explode("\n", $this->getCommandOutput("git ls-files"));

		// this filter would accept only files that are present in Git
		$finder->filter(function (SplFileInfo $file) use (&$files) {
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

	public function getRules() {
		return array(
			'controls_spaces',
			'-eof_ending',
			'function_declaration',
			'include',
			'linefeed',
			'php_closing_tag',
			'return',
			'trailing_spaces',
			'unused_use',
			'visibility',
			'elseif',
			'extra_empty_lines',
			'short_tag',
		);
	}
}
