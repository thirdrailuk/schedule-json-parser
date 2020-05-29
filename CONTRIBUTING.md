# Contributing

 * Coding standard for the project is [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
 * The project aims to follow most [object calisthenics](https://www.slideshare.net/guilhermeblanco/object-calisthenics-applied-to-php)
 * Any contribution must provide tests for additional introduced conditions
 * Any un-confirmed issue needs a failing test case before being accepted
 * Pull requests must be sent from a new hotfix/feature branch, not from `master`.

## Installation

### Naitive

To install the project and run the tests, you need to clone it first:

```bash
git clone git@github.com:trainjunkies-packages/schedule-json-parser.git
```

You will then need to run a [Composer](https://getcomposer.org/) installation:

```bash
cd schedule-json-parser
curl -s https://getcomposer.org/installer | php
composer.phar update
```

### Docker Container

The project comes with a [Docker](https://www.docker.com/get-started) development environment to reduce overall dependencies. Providing Docker is installed the container can be created and accessed with the following commands inside the cloned git directory.

```bash
docker-compose up -d --build
docker-compose run --rm app sh
```

## Testing & Analysis

[PHPUnit](https://phpunit.de/) and [PHPSpec](http://www.phpspec.net/en/stable/) are used for testing.

For convenience a Composer command handles test exeuction.

```bash
composer.phar spec
composer.phar integration
```

Prior to merging a Pull Request code style checks and static analysis must also pass.

```bash
composer.phar sniff
composer.phar stan
composer.phar psalm
```

The entire continus integration build can be executed with the following Composer command.

```bash
composer.phar ci
```

Please ensure all new features or conditions are covered by tests and the CI task passes successfuly before raising a Pull Request.