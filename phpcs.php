<?php

// installed via composer?
if (file_exists($autoload = __DIR__ . '/../../autoload.php')) {
	require_once $autoload;
} else {
	require_once __DIR__ . '/vendor/autoload.php';
}

return new ED\CS\Config\ED();
