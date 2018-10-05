<?php

// do not use composer here
// causes fatals when different symfony versions installed
require_once __DIR__ . '/src/ED.php';
require_once __DIR__ . '/src/Filter/FilterInterface.php';
require_once __DIR__ . '/src/Filter/DefaultFilter.php';
require_once __DIR__ . '/src/Filter/GitFilter.php';
require_once __DIR__ . '/src/PlatformVersion.php';
require_once __DIR__ . '/src/ProcessRunner.php';
require_once __DIR__ . '/src/ProjectRootDetector.php';
require_once __DIR__ . '/src/RuleBuilder.php';
require_once __DIR__ . '/src/Rules/RuleInterface.php';
require_once __DIR__ . '/src/Rules/DefaultRules.php';
require_once __DIR__ . '/src/Rules/PlatformRules.php';

return new ED\CS\Config\ED();
