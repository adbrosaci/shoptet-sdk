<?php declare(strict_types = 1);

use Dotenv\Dotenv;
use Tracy\Debugger;

require __DIR__ . '/../vendor/autoload.php';

Debugger::enable(
	mode: Debugger::Development,
	logDirectory: __DIR__ . '/log',
);
Debugger::$maxLength = 10000;

(Dotenv::createUnsafeImmutable(__DIR__))
	->load();
