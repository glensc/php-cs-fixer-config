<?php

namespace ED\CS\Config\Test;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

abstract class TestCase extends PHPUnit_Framework_TestCase {

	/**
	 * Get Config instance configured to run in $dir
	 *
	 * @return \ED\CS\Config\ED
	 */
	protected function getConfig($dir = null) {
		/**
		 * @var \ED\CS\Config\ED|PHPUnit_Framework_MockObject_MockObject $stub
		 */
		$stub = $this->getMockBuilder('\\ED\\CS\\Config\\ED')
			->setMethods(array('applyGitFilter'))
			->getMock();

		$stub->method('applyGitFilter');

		$stub->getFinder()->in($dir ?: $this->getProjectRoot() . '/tests/res');

		return $stub;
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