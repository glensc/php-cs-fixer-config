<?php

namespace ED\CS\Config;

use PhpCsFixer\Config;

class ED extends Config {
	public function __construct() {
		parent::__construct('ED');

		$this->setUsingCache(true);

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

	public function getRules() {
		return array(
			'no_useless_else' => true,
		);
	}
}
