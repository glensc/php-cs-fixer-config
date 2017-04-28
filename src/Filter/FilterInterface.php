<?php

namespace ED\CS\Config\Filter;

interface FilterInterface {
	/**
	 * @param \Symfony\CS\Finder\DefaultFinder|\Symfony\CS\FinderInterface|\Traversable $finder
	 */
	public function apply($finder);
}