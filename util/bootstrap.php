<?php
    /**
     * This file is used to configure the EntityGenerator.
     * @author Paul Allsopp <paul.allsopp@digital-pig.com>
     */
	use Doctrine\ORM\Tools\Setup;
	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\Exception;
	use Doctrine\DBAL\DriverManager;

	require_once '../vendor/autoload.php';
	require_once __DIR__ . '/../config/config.php'; /** @var array $dbConData */

	// Doctrine configuration
	$config_obj = Setup::createAnnotationMetadataConfiguration(
        [ENTITY_PATH],
        IS_DEV_MODE,
        PROXY_PATH,
        CACHE,
        ANNOTATION_READER
    );

	// Doctrine connection
	$db_params = [
		'dbname' => DB_NAME,
		'user' => DB_USER,
		'password' => DB_PASS,
		'host' => DB_HOST,
		'driver' => 'pdo_mysql'
	];

	try {
		$conn_obj = DriverManager::getConnection($db_params);
		$entity_manager = EntityManager::create($conn_obj, $config_obj);

		$conn_obj->getDatabasePlatform()->registerDoctrineTypeMapping('set', 'string');
		$conn_obj->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

	} catch (\Doctrine\DBAL\Exception $conn_ex) {
		echo $conn_ex->getMessage(); exit;
	} catch (\Doctrine\ORM\ORMException $orm_ex) {
		echo $orm_ex->getMessage(); exit;
	}

