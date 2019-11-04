<?php

namespace glen\PhpCsFixerConfig;

use Composer\Semver\Semver;

class PlatformVersion
{
    /** @var string */
    private $dir;

    public function __construct($dir) {
        $this->dir = $dir;
    }

    /**
     * Return true if php version specified in platform override satisfies $constraints.
     *
     * @param string $constraints
     * @return bool
     */
    public function satisfies($constraints) {
        $version = $this->getPhpVersion();
        if (!$version) {
            return false;
        }

        return Semver::satisfies($version, $constraints);
    }

    public function getPhpVersion() {
        $version = $this->versionFromLock();
        if ($version) {
            return $version;
        }

        return $this->versionFromComposer();
    }

    /**
     * Extract Platform version from composer.lock
     */
    private function versionFromLock() {
        $lockFile = $this->readJsonFile('composer.lock');

        /*
         * Look for platform override
         * "platform-overrides": {
         *   "php": "5.6.0"
         * }
         */
        if (isset($lockFile['platform-overrides']['php'])) {
            return $lockFile['platform-overrides']['php'];
        }

        return null;
    }

    /**
     * Extract Platform version from composer.lock
     */
    private function versionFromComposer() {
        $composerFile = $this->readJsonFile('composer.json');

        /*
         * Look for platform override
         *
         * "config": {
         *   "platform": {
         *     "php": "5.6.0"
         *   }
         * }
         */
        if (isset($composerFile['config']['platform']['php'])) {
            return $composerFile['config']['platform']['php'];
        }

        return null;
    }

    private function readJsonFile($fileName) {
        $filePath = $this->dir . DIRECTORY_SEPARATOR . $fileName;
        if (!file_exists($filePath)) {
            return [];
        }

        return json_decode(file_get_contents($filePath), true);
    }
}
