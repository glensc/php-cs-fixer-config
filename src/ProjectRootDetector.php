<?php

namespace glen\PhpCsFixerConfig;

use RuntimeException;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ProjectRootDetector {
	/**
	 * @throws RuntimeException
	 * @return string
	 */
	public static function detect() {
		try {
			$topDir = ProcessRunner::run('git rev-parse --show-toplevel');
		} catch (ProcessFailedException $e) {
			throw new RuntimeException('Unable to get project root dir: ' . $e->getMessage());
		}

		if (!$topDir) {
			throw new RuntimeException('Unable to detect project root');
		}

		// ran via realpath to canonicalize path for windows
		$absPath = realpath($topDir);
		if (!$absPath) {
			throw new RuntimeException("Unable to resolve path: $topDir");
		}

		return $absPath;
	}
}
