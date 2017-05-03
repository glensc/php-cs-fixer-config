<?php

namespace ED\CS\Config;

use Symfony\CS\Config\Config;
use Symfony\CS\FixerInterface;

class ED extends Config {
	protected $usingCache = true;

	/**
	 * Private copy of finder.
	 *
	 * @see getFinder;
	 * @var \Symfony\CS\Finder\DefaultFinder|\Symfony\CS\FinderInterface|\Traversable
	 */
	private $finderInstance;

	public function __construct() {
		parent::__construct('ED', 'The configuration for ED PHP applications');

		$this->level = FixerInterface::NONE_LEVEL;
		$this->fixers = $this->getRules();
	}

	/**
	 * Hook to configure finder object after constructor but before CS-Fixer uses it.
	 *
	 * This allows to enable/disable git filter.
	 *
	 * @return \Symfony\CS\Finder\DefaultFinder|\Symfony\CS\FinderInterface|\Traversable
	 */
	public function getFinder() {
		// configure finder once.
		if ($this->finderInstance) {
			return $this->finderInstance;
		}

		$finder = parent::getFinder();

		$this->applyGitFilter($finder);

		// revert *.xml from DefaultFinder
		$finder
			->notPath('{^\.idea/.+\.xml$}');

		$finder
			->notPath('#^config/envSpecific/.+$#');

		// because php-cs-fixer maintainers are idiots
		// https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/1027
		$finder
			->ignoreDotFiles(false)
			->name('.php_cs');

		return $this->finderInstance = $finder;
	}

	/**
	 * Setup Finder to inspect only files that are present in Git index.
	 */
	public function applyGitFilter() {
		$this->applyFinderFilter(new Filter\GitFilter());
	}

	/**
	 * Apply $filter to $finder instance.
	 *
	 * @param Filter\FilterInterface $filter
	 * @return $this
	 */
	protected function applyFinderFilter(Filter\FilterInterface $filter) {

		$filter->apply($this->finder);

		return $this;
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
