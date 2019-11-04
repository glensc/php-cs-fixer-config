<?php

namespace glen\PhpCsFixerConfig\Test;

use glen\PhpCsFixerConfig\Filter\GitFilter;
use PhpCsFixer\Finder;

class GitHelperTest extends TestCase {
	/** @var Finder */
	protected $finder;

	/** @var \glen\PhpCsFixerConfig\Filter\GitFilter */
	protected $helper;

	public function setUp() {
		$this->finder = new Finder();

		$gitFilter = new GitFilter(dirname(__DIR__));
		$gitFilter->apply($this->finder);
	}

	public function testFiles() {
		$files = $this->getFinderRelativePaths($this->finder);

		$this->assertContains($this->path('tests/GitHelperTest.php'), $files, 'Must contain tests/GitHelperTest.php');

		$unique = array_unique($files);
		$this->assertEquals($unique, $files, 'File list does not contain duplicate entries');

		$this->assertNotContains($this->path('.idea/workspace.xml'), $files);
		$this->assertNotContains($this->path('vendor/autoload.php'), $files);
	}
}
