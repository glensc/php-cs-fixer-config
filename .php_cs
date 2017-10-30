<?php
# vim:ft=php

$config = require __DIR__ . '/phpcs.php';
$config->getFinder()->in(__DIR__);

$finder = $config->getFinder();

// test data that must be scanned for fixes
$finder->notPath('tests/res');

return $config;
