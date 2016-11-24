<?php

namespace ED\CS\Config\Test;

use ED\CS\Config\Helper\GitHelper;
use Symfony\CS\Finder\DefaultFinder;

class GitHelperTest extends TestCase {

	/** @var DefaultFinder */
	protected $finder;

	/** @var  GitHelper */
	protected $helper;

	public function setUp() {
		$this->finder = new DefaultFinder();
		$this->helper = new GitHelper($this->finder);
		$this->helper->findGitFiles();
	}

	public function testFiles() {
		$files = $this->getFilesList();

		$this->assertContains('src/ED.php', $files);
		$this->assertNotContains('.idea/workspace.xml', $files);
		$this->assertNotContains('vendor/autoload.php', $files);
	}

	private function getFilesList() {
		$files = array();
		foreach ($this->finder as $fi) {
			$files[] = $fi->getRelativePathname();
		}

		return $files;
	}
}