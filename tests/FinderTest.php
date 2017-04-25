<?php

namespace ED\CS\Config\Test;

class FinderTest extends TestCase {
	/**
	 * Test that finder root has effect. i.e that it doesn't default to project root.
	 */
	public function testFinderRoot() {
		$finder = $this->getConfig(__DIR__ . '/res/singlefile')->getFinder();
		$files = iterator_to_array($finder->getIterator());

		// we find just one file
		$file = $this->getProjectRoot() . '/tests/res/singlefile/singlefile.php';
		$this->assertEquals(array($file), array_keys($files), "Must contain just one file from subdir");
	}

	/**
	 * Test that finder does not find envSpecific file from tested project root.
	 * Our tested project root is "tests/res"
	 */
	public function testEnvSpecificExclude() {
		$finder = $this->getConfig()->getFinder();
		$files = iterator_to_array($finder->getIterator());

		$file = $this->getProjectRoot() . '/tests/res/config/envSpecific/newlines.php';
		$this->assertNotContains($file, $files, "Must not contain envSpecific files that are from project root");
	}

	/**
	 * Test that excluded envSpecific starts from project root, i.e if it's some subdir, the files are still found.
	 */
	public function testEnvSpecificSpecificExclude() {
		$finder = $this->getConfig($this->getProjectRoot())->getFinder();
		$files = iterator_to_array($finder->getIterator());

		// must not contain "envSpecific" files
		$file = $this->getProjectRoot() . '/tests/res/config/envSpecific/newlines.php';
		$this->assertContains($file, $files, "Must contain envSpecific file that is not in root");
	}
}