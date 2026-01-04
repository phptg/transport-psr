# Internals

## Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

## Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
composer psalm
```

## Code style

Package used [PHP CS Fixer](https://cs.symfony.com/) to maintain [PER CS 3.0](https://www.php-fig.org/per/coding-style/)
code style. To check and fix code style:

```shell
composer cs-fix
```

## Dependencies

Use [Composer Dependency Analyser](https://github.com/shipmonk-rnd/composer-dependency-analyser) to
detect [Composer](https://getcomposer.org) dependency issues (unused dependencies, shadow dependencies,
misplaced dependencies):

```shell
composer dependency-analyser
```
