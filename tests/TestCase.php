<?php

namespace ED\CS\Config\Test;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Finder\Finder;

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

		$absPath = realpath($dir ?: $this->getProjectRoot() . '/tests/res');
		$stub->getFinder()->in($absPath);

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

	/**
	 * Iterate over finder and return relative paths from it.
	 *
	 * @param Finder $finder
	 * @return array
	 */
	protected function getFinderRelativePaths(Finder $finder) {
		$files = array();
		foreach ($finder as $fi) {
			$files[] = $fi->getRelativePathname();
		}

		return $files;
	}

	/**
	 * Return OS native path.
	 * NOTE: using short method name because the method is going to be used a lot.
	 *
	 * @param string $path Path with Unix directory separators
	 * @return string
	 */
	protected function path($path) {
		$components = explode('/', $path);

		return implode(DIRECTORY_SEPARATOR, $components);
	}
}