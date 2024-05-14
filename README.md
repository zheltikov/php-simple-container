# php-simple-container

A simple [Dependency Injection](https://en.wikipedia.org/wiki/Dependency_injection) container implementation
of [PSR-11](https://www.php-fig.org/psr/psr-11/)

## Usage

First, install this package via [Composer](https://getcomposer.org):

```shell
$ composer require zheltikov/simple-container
```

Then, you can create an instance of the DI container in your project, for example:

```php
<?php

use Psr\Container\ContainerInterface;
use Zheltikov\SimpleContainer\{Container};
use Zheltikov\SimpleContainer\Entry\{CachedEntry};
use Zheltikov\SimpleContainer\Parameter\{ComputedParameter, EnvParameter, RawParameter};
use Zheltikov\SimpleContainer\Service\{ClassService, ComputedService};

// You can define parameters and services in this container
$container = new Container(entries: [
    // You can define "raw" parameters (as-is) ...
    'db_host' => new RawParameter(value: 'localhost'),
    'db_port' => new RawParameter(value: 5432),
    
    // ... or read them from "env" variables ...
    'db_username' => new EnvParameter(name: 'DB_USERNAME', default: 'postgres'),
    'db_password' => new EnvParameter(name: 'DB_PASSWORD'),
    
    // ... or "compute" them:
    'dsn' => new ComputedParameter(fn(ContainerInterface $container) => sprintf(
        'pgsql:host=%s;port=%d;user=%s;password=%s',
        $container->get('db_host'),
        $container->get('db_port'),
        $container->get('db_username'),
        $container->get('db_password'),
    )),
    
    // You can then define some services...
    // ... like "computed" services ...
    'pdo' => new ComputedService(fn (ContainerInterface $container) => new PDO($container->get('dsn'))),
    'repository' => new ComputedService(fn (ContainerInterface $container) => new MyRepository($container->get('pdo'))),
    
    // ... or simple "class" services:
    'my_simple_service' => new ClassService(
        name: MyHttpClient::class,
        // constructor arguments:
        args: ['some', 'args'],
    ),
    
    // You can also "cache" entries (useful for singleton services):
    'my_cached_parameter' => new CachedEntry(
        // note that this will be executed only once when this parameter will
        // be first accessed, and then will be cached
        inner: new ComputedParameter(fn() => microtime(true)),
    ),
    'my_cached_service' => new CachedEntry(
        // this service will also be computed upon first access and then cached
        inner: new ClassService(DateTimeImmutable::class, args: ['now']),
    ),
]);


// Then, you can request entries from the container, like so:
echo $container->get('dsn');
// pgsql:host=localhost;port=5432;user=...;password=...

var_dump($container->get('repository'));
// object(MyRepository)#1 (0) { ... }
```
