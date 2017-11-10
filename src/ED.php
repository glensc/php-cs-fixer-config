<?php

namespace ED\CS\Config;

use PhpCsFixer\Config;

class ED extends Config {
	public function __construct() {
		parent::__construct();

		$this->setUsingCache(true);
		$this->setRules($this->getDefaultRules());
		$this->applyFinderFilter(new Filter\GitFilter());
		$this->applyFinderFilter(new Filter\DefaultFilter());
	}

	/**
	 * Apply $filter to $finder instance.
	 *
	 * @param Filter\FilterInterface $filter
	 * @return $this
	 */
	protected function applyFinderFilter(Filter\FilterInterface $filter) {
		$filter->apply($this->getFinder());

		return $this;
	}

	public function getDefaultRules() {
		return array(
			'@PSR2' => true,
			// PSR2 that conflicts with Delfi Standard
			'indentation_type' => false,
			'class_definition' => false,
			'braces' => false,

			'no_useless_else' => true,
		);
	}
}
