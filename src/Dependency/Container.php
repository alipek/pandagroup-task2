<?php


namespace Recruitment\Dependency;


class Container
{
    private static ?self $single = null;
    private $config = [];

    private $services = [];

    public function __construct($config)
    {
        $this->config = $config;
        $this->set(self::class, $this);
    }

    public static function getInstance(array $configContainer): self
    {
        if (self::$single === null) {
            self::$single = new self($configContainer);
        }
        return self::$single;
    }


    public function get($name): object
    {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }
        $service = $this->createService($name);
        return $this->services[$name] = $service;
    }

    public function set(string $serviceName, $service): void
    {
        $this->services[$serviceName] = $service;
    }

    private function createService($name): object
    {

        if (!\class_exists($name)) {
            throw new \RuntimeException("Can't create service {$name}");
        }
        $classRef = new \ReflectionClass($name);
        $constructRef = $classRef->getConstructor();
        $constructArgs = $this->config[$name] ?? [];
        if (null !== $constructRef) {
            foreach ($constructRef->getParameters() as $parameterRef) {
                $argumentType = $parameterRef->getClass();
                if ($argumentType !== null && !isset($constructArgs[$parameterRef->getPosition()])) {
                    $constructArgs[$parameterRef->getPosition()] = $this->get($argumentType->getName());
                }
            }
        }
        return $this->services[$name] = $classRef->newInstance(...$constructArgs);
    }
}