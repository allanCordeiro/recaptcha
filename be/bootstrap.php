<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), 
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);

$conn = array(
    'driver'    =>  'pdo_mysql',
    'user'      =>  'teste',
    'password'  =>  '123@456',
    'dbname'    =>  'base_teste'
);

$entityManager = EntityManager::create($conn, $config);