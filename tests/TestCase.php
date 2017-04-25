<?php

namespace ED\CS\Config\Test;

use PHPUnit_Framework_TestCase;

abstract class TestCase extends PHPUnit_Framework_TestCase {

	/**
	 * Get Config instance configured to run in $dir
	 *
	 * @return \ED\CS\Config\ED
	 */
	protected function getConfig($dir = null) {
		$config = new \ED\CS\Config\ED();
		$config->useGitFilter(false);
		$config->getFinder()->in($dir ?: $this->getProjectRoot() . '/tests/res');

		return $config;
	}

	/**
	 * Return path to this project root
	 *
	 * @return string
	 */
	protected function getProjectRoot() {
		return dirname(__DIR__);
	}
}