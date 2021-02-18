# INSTRUCTIONS

## INSTALL Lando
Install Lando for your OS: https://docs.lando.dev/basics/installation.html

## START A NEW PROJECT

Run `bash lando/scripts/init.sh` in the project root folder where this submodule is initialised.

Then run `lando start` in the project root.

Then run `lando composer install` in the project root.

Goto http://drupal9.lndo.site and isntall the site.

## Lando tools
On top of Lando default commands this project defines a custom set of tools.
These tools were added to ease repetitive tasks on the project.

###`lando drupal`
Runs project definded Drupal console commands in the *webroot*.

###`lando clean`
Deletes vendor, core, contributed folders. Useful for clean start.

###`lando phpunit <option>FILTER`
Runs all unit tests. If FILTER is provided it will add it as the --filter option to the phpunit command. Defaults to `.`

###`lando redis-cli`
Provides cli integration for the *redis* service

###`lando update`
Runs drush updates.

## REBUILD
To completely rebuild the project run
`lando destroy -y && bash lando/scripts/init.sh && lando start`

## XDEBUG (BROWSER)
Put this in .lando.local.yml in the root:

```
# To activate this feature, copy this file as .lando.local.yml.
# Further read on configuration file load order is available on:
# https://docs.lando.dev/config/lando.html#base-file
config:
  xdebug: true

services:
  appserver:
    xdebug: true
    overrides:
      environment:
        XDEBUG_MODE:
        PHP_IDE_CONFIG: "serverName=appserver"

events:
  post-start:
    - appserver: export PHP_IDE_CONFIG="serverName=appserver"
```

lando rebuild
lando start
lando xdebug debug

Enable listener and set a breakpoint in PHPStorm.
