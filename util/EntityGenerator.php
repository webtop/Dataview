<?php
    /**
     * EntityGenerator.php
     * This file connects to a MySQL DB and generates a Doctrine Entity class for each table.
     * Setup is done in bootstrap.php.
     * @author Paul Allsopp <paul.allsopp@digital-pig.com>
     */
	use Doctrine\ORM\Tools\Setup;
	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\Exception;
	use Doctrine\DBAL\DriverManager;

	require __DIR__ . '/bootstrap.php'; /** @var Doctrine\ORM\EntityManager $entity_manager */

	$class_loader = new \Doctrine\Common\ClassLoader('Entities', ENTITYPATH);
	$class_loader->register();

	$class_loader = new \Doctrine\Common\ClassLoader('Proxies', PROXYPATH);
	$class_loader->register();

	echo "\nProcessing tables...";
	try {
		$driver = new \Doctrine\ORM\Mapping\Driver\DatabaseDriver(
			$entity_manager->getConnection()->getSchemaManager()
		);

		$entity_manager->getConfiguration()->setMetadataDriverImpl($driver);
		$factory = new \Doctrine\ORM\Tools\DisconnectedClassMetadataFactory($entity_manager);
		$factory->setEntityManager($entity_manager);
		$classes = $driver->getAllClassNames();
		$metadata = $factory->getAllMetadata();

		$generator = new Doctrine\ORM\Tools\EntityGenerator();
		$generator->setUpdateEntityIfExists(true);
		$generator->setGenerateStubMethods(true);
		$generator->setGenerateAnnotations(true);
		$generator->generate($metadata, ENTITYPATH);

	} catch (\Doctrine\DBAL\Exception $conn_ex) {
		echo $conn_ex->getMessage(); exit;
	} catch (\Doctrine\ORM\ORMException $orm_ex) {
		echo $orm_ex->getMessage(); exit;
	}

	echo "\nCleaning up files...";
	foreach ($classes as &$class) {
		cs_formatter(ENTITYPATH . $class . '.php', '', '');
	}

	echo "\nDone!\n\n";

	function cs_formatter(string $filepath, string $namespace, string $table_prefix = ''): void
    {
		$content = file_get_contents($filepath);
		@unlink($filepath);

		// 1. Replace any table prefixing
		$content = str_replace($table_prefix, 'Vt', $content);

		// 2. Convert spaces to tabs
		$content = str_replace('    ', "\t", $content);

		// 3. Add strict declare and namespace
		$content = (string) preg_replace_callback('/^<\?php(\s+)use\s/', static fn(array $match): string => '<?php' . "\n\n"
			. 'declare(strict_types=1);' . "\n\n"
			/*. 'namespace ' . $namespace . ';' . "\n\n\n"*/
			. 'use ', $content);

		// 4. Fix relations to other entity
		$content = (string) preg_replace_callback('/@(param|return|var)\s(\\\\\w+)/', static fn(array $match): string => '@' . $match[1] . ' ' . (\class_exists($match[2]) ? $match[2] : trim($match[2], '\\')), $content);

		// 5. Fix namespace in relation annotation
		$content = (string) preg_replace_callback('/(@ORM\\\\\w+\(targetEntity=")([^"]+)"/', static fn(array $match): string => $match[1] . '\\' . $namespace . '\\' . $match[2] . '"', $content);

		// 6. Fix annotation type in setter
		$content = (string) preg_replace_callback('/(function\sset\w+)\((\\\\\w+)\s/', static fn(array $match): string => $match[1] . '(' . (\class_exists($match[2]) ? $match[2] : trim($match[2], '\\')) . ' ', $content);

		// 7. Add self typehint to setters
		$content = (string) preg_replace_callback('/(public\sfunction\s\w+[^)]+)\)(\s*[^:](?:\n|[^}])+?return\s\$this;)/', static fn(array $match): string => $match[1] . '): self' . $match[2], $content);

		$filepath = str_replace($table_prefix, 'Dv', $filepath);
		file_put_contents($filepath, $content);
	}
