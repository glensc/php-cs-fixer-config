<?php

namespace glen\PhpCsFixerConfig\Test;

use glen\PhpCsFixerConfig\PlatformVersion;

class PlatformDetectTest extends TestCase
{
    public function testComposerNoVersion() {
        $dir = __DIR__ . '/res/composer-json-only';
        $version = new PlatformVersion($dir);
        $this->assertFalse($version->satisfies('^0'));
    }

    public function testComposerVersion() {
        $dir = __DIR__ . '/res/composer-json';
        $version = new PlatformVersion($dir);
        $this->assertFalse($version->satisfies('^4'));
        $this->assertTrue($version->satisfies('^5.6'));
        $this->assertFalse($version->satisfies('^7.1'));
    }

    public function testComposerLock() {
        $dir = __DIR__ . '/res/composer-lock';
        $version = new PlatformVersion($dir);

        $this->assertFalse($version->satisfies('^4'));
        $this->assertTrue($version->satisfies('^5.6'));
        $this->assertFalse($version->satisfies('^7.1'));
    }
}
