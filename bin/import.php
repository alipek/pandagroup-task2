<?php
include_once '../src/autoload.php';

if ($argc < 2) {
    fwrite(STDERR, "Missing argument for csv file path.");
    exit(1);
}
$importFilePath = realpath($argv[1]);

if ($importFilePath === false) {
    fwrite(STDERR, "Filepath not found: {$argv[1]}");
    exit(1);
}
$containerConf = require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'container.php';
$container = \Recruitment\Dependency\Container::getInstance($containerConf);
$connection = $container->get(\Recruitment\Dbal\Connection::class);


function generatorFile(string $importFilePath): \Generator
{
    $importFileObject = new SplFileObject($importFilePath);
    $importFileObject->setFlags(SplFileObject::READ_CSV);
    $header = $importFileObject->fgetcsv();
    while (!$importFileObject->eof()) {
        $data = $importFileObject->fgetcsv();
        if(false == $data || count($header) !== count($data)) continue;
        yield array_combine($header, $data);
    }

}

$dataGenerator = generatorFile($importFilePath);
$connection->importData($dataGenerator);