<?php

$loader = @include __DIR__ . '/../vendor/autoload.php';
$loader->addPsr4('Tests\\', __DIR__);

include(__DIR__ . '/../config.php');