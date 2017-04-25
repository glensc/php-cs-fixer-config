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
}