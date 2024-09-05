CMS Lo Pati v5.0
================

A fresh new Symfony 6.4 CMS webapp project to manage a Lo Pati content resources.

---

#### Installation requirements

 * PHP 8.3+
 * MySQL 8.0+
 * Composer 2.0+
 * Git 2.0+
 * Meilisearch 1.0+

#### Installation instructions

```bash
$ git git@github.com:Flexible-User-Experience/lo-pati-6.git
$ cd lo-pati-6
$ cp env.dist .env
$ nano .env
$ composer install
$ php bin/console messenger:consume async --env=prod
$ php bin/console meilisearch:create --env=prod
$ php bin/console meilisearch:import --env=prod
```

Remember to edit `.env` config file according to your system environment needs.

#### Testing suite commands

```bash
$ ./scripts/developer-tools/test-database-reset.sh
$ ./scripts/developer-tools/run-test.sh
```

#### Developer important notes

 * Read about how to start a local web server instance [here](https://symfony.com/doc/current/setup/symfony_server.html)

#### Messenger queues

In a production environment remember to properly configure Messenger queue consumers handled by a Supervisor instance. Read [these](https://symfony.com/doc/current/messenger.html#messenger-supervisor) instructions.

#### Code Style notes

Execute following link to be sure that php-cs-fixer will be applied automatically before every commit. Please, check https://github.com/FriendsOfPHP/PHP-CS-Fixer to install it globally (manual) in your system.

```bash
$ ln -s ../../scripts/githooks/pre-commit .git/hooks/pre-commit
```
