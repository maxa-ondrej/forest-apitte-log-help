<?php

declare(strict_types=1);

use Contributte\Middlewares\Application\IApplication;

// Uncomment this line if you must temporarily take down your site for maintenance.
//require 'maintenance.php';
//die();

// Let bootstrap create Dependency Injection container.
$container = require_once __DIR__ . '/../app/Bootstrap.php';

// Run application.
$container->getByType(IApplication::class)->run();
