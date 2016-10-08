<?php

require_once __DIR__ . '/vendor/autoload.php';

$config = new ED\CS\Config\ED();
$config->getFinder()->in(__DIR__);

return $config;