<?php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/vendor/autoload.php';

// Get Database Credentials and other config from /config/doctrine.yaml file
$config = Yaml::parseFile(__DIR__ . '/config/doctrine.yaml');
$paths = $config['doctrine']['orm']['metadata_dirs'];
$isDevMode = $config['doctrine']['orm']['isDevMode'];

// Database Params to be passed to the Connection Driver Manager setup
$dbParams = [
    'driver' => $config['doctrine']['dbal']['driver'],
    'user' => $config['doctrine']['dbal']['user'],
    'password' => $config['doctrine']['dbal']['password'],
    'dbname' => $config['doctrine']['dbal']['dbname'],
    'host' => $config['doctrine']['dbal']['host'],
    'port' => $config['doctrine']['dbal']['port'],
];

// Initialize ORM configuration and Connection Driver to be used by the Entity Manager; this is to make sure our EntityManager is connecting to our defined database
$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);

// Create the Entity Manager which will be used to access the database
$entityManager = new EntityManager($connection, $config);