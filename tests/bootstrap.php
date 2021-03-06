<?php

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('Jsor\Doctrine\PostGIS\\', __DIR__.'/fixtures');
$loader->addPsr4('Jsor\Doctrine\PostGIS\\', __DIR__);

$GLOBALS['TESTS_TEMP_DIR'] = __DIR__.'/temp';

Doctrine\Common\Annotations\AnnotationRegistry::registerFile(
    __DIR__.'/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
);

$reader = new \Doctrine\Common\Annotations\AnnotationReader();
$reader = new \Doctrine\Common\Annotations\CachedReader($reader, new \Doctrine\Common\Cache\ArrayCache());
$GLOBALS['ANNOTATION_READER'] = $reader;
