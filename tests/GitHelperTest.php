<?php

namespace ED\CS\Config\Test;

use ED\CS\Config\Filter\GitFilter;
use Symfony\CS\Finder\DefaultFinder;

class GitHelperTest extends TestCase {

	/** @var DefaultFinder */
	protected $finder;

	/** @var GitFilter */
	protected $helper;

	public function setUp() {
		$this->finder = new DefaultFinder();
		$this->finder->in(dirname(__DIR__));

		$gitFilter = new GitFilter();
		$gitFilter->apply($this->finder);
	}

	public function testFiles() {
		$files = $this->getFilesList();

		$this->assertContains($this->path('src/ED.php'), $files, "Must contain src/ED.php");
		$this->assertNotContains($this->path('.idea/workspace.xml'), $files);
		$this->assertNotContains($this->path('vendor/autoload.php'), $files);
	}

	private function getFilesList() {
		$files = array();
		foreach ($this->finder as $fi) {
			$files[] = $fi->getRelativePathname();
		}

		return $files;
	}
}