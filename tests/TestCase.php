<?php

namespace glen\PhpCsFixerConfig\Test;

use glen\PhpCsFixerConfig\Config;
use PHPUnit_Framework_MockObject_MockObject;
use Symfony\Component\Finder\Finder;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Get Config instance configured to run in $dir
     *
     * @return \glen\PhpCsFixerConfig\Config
     */
    protected function getConfig($dir = null) {
        /**
         * @var \glen\PhpCsFixerConfig\Config|PHPUnit_Framework_MockObject_MockObject $stub
         */
        $stub = $this->getMockBuilder(Config::class)
            ->setMethods(['applyFinderFilter'])
            ->getMock();

        $stub->method('applyFinderFilter');

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
     * @return array
     */
    protected function getFinderRelativePaths(Finder $finder) {
        $files = [];
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
