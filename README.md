# androfit-api

This API was bootstrapped with [Symfony5](https://github.com/symfony/symfony) and [API Platform](https://github.com/api-platform/api-platform).

## Requirements

- PHP 7.2
- composer
- mysql >= 5.7

## Installation and configuration

### Install

```bash
$ composer install
```

### Environment configuration

Create a `.env` from template with the credentials.

### JWT Generation

```bash
$ ./.generateJWTKeys 
```

### Database implementation

```bash
$ bin/console doctrine:database:create
$ bin/console doctrine:migrations:migrate
```

### Launch the webserver (local only)

```bash
$ php -S 127.0.0.1:8000 -t public 
```
