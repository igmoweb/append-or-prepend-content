# Append or Prepend Content

Repository for Append or Prepend Content Plugin for WordPress: https://wordpress.org/support/plugin/append-or-prepend-content/

## Requirements

- [Composer](https://getcomposer.org/)
- [node and npm](https://nodejs.org/es/). Recommended to use [nvm](https://github.com/nvm-sh/nvm)

## Development process

- Clone this repo.
- Run `npm install`. This will install a set of dependencies to make builds and WordPress.org workflows better. It also run PHPCS to format and clean the code.
- Whenever a commit is done, PHPCS will run warning or erroring if something needs to be said about the committed code. 

## PHPUnit

- If you have MySQL and PHP locally installed, run `./vendor/bin/phpunit`, otherwise you'll need [Docker](https://www.docker.com/) to execute `./bin/phpunit.sh`