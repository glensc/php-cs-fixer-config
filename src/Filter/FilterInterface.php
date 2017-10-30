<?php

namespace ED\CS\Config\Filter;

use Symfony\Component\Finder\Finder;

interface FilterInterface {
	/**
	 * @param Finder $finder
	 */
	public function apply(Finder $finder);
}
