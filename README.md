# WordPress Core Web Vitals Lab

Core Web Vitals is a reality. These new metrics created to measure the user page experience [will be part of the Google ranking algorithm in May 2021](https://developers.google.com/search/blog/2020/11/timing-for-page-experience). The objective of this project is to be a laboratory of testing how the [WordPress](http://wordpress.org/) ecosystem bahaves with these metrics.

The objective of this project is to discuss how to improve the Lighthouse metrics on the WordPress ecosystem.

This configuration comes with [Varnish](https://varnish-cache.org/) to cache requests and reduce the server response time. For tests purpose, it is possible use or bypass it. See _How to serve_ section to check how do that.

[Docker Compose](https://docs.docker.com/compose/) is the base to the configuration to serve the WordPress application. So, to run the project it is necessary to have [Docker](https://www.docker.com/) installed.

## How to install

```bash
$ docker-compose build --pull && docker-compose pull
$ docker-compose up -d db
$ docker-compose run --rm wordpress wp-install
```

## How to serve

```bash
$ docker-compose up -d server
```

The WordPress application will be served on 4 ports:

- __[443](https://localhost)__: Varnish over SSL and HTTP/2
- __[80](http://localhost)__: Varnish over HTTP/1.1
- __[44380](https://localhost:44380)__: Without Varnish over SSL and HTTP/2
- __[8080](http://localhost:8080)__: Without Varnish over HTTP/1.1

## Plugin

We have a plugin called _Core Web Vitals Performance Optimize_ inner the project. This plugin has proof of concept to add page performance improvements to WordPress Core and the entire ecosystem.

This plugin is symlinked to the directory plugin and it is automatically activated by installation script.

## Services

### WordPress

A PHP image with the WordPress modules dependencies.

The image is built with [WP-CLI](https://wp-cli.org/) to help manage the application. See _How to run WP-CLI commands_ section to get more information how to use it.

It was added Xdebug extension to help debug the application. See _How to debug_ section to see how to enable and config the integration with the IDE.

### Nginx

Used to proxy the requests to Varnish and PHP-FPM.

### Varnish

The cache system to delivery the requests faster than process them every time.

### MariaDB

The database service to store application data.

### Plugin test

Service to run _Core Web Vitals Performance Optimize_ unit test. See _How to run plugin unit tests_ section to see how run the tests.

### Plugin coding standards

Service to check if the code standard of the plugin. See _How to check plugin coding standards_ section to see how run the checker.

## How To

### How to run WP-CLI commands?

```bash
$ docker-compose run --rm wp [command]
```

### How to debug?

It is necessary change the value of `XDEBUG_MODE` from `off` to `debug` on `docker-compose.yml` file and restart the WordPress service if it is already running.

```bash
$ docker-compose restart wordpress
```

For VS Code integration, the [PHP Debug](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug) should be installed and active. The `launch.json` must have this configuration:

```json
{
    "name": "Listen for XDebug",
    "type": "php",
    "request": "launch",
    "port": 9003,
    "pathMappings": {
        "/cwv-perf-optimize": "${workspaceRoot}/cwv-perf-optimize",
        "/var/www/html": "${workspaceRoot}/public",
    }
}
```

### How to run plugin unit tests?

```bash
$ docker-compose run --rm plugin-tests
```

The unit tests images come with [phpunit-watcher](https://github.com/spatie/phpunit-watcher) shipped to keep PHPUnit running and waiting changes to run the tests again.

```bash
$ docker-compose run --rm plugin-tests phpunit-watcher watch
```

### How to test cli commands?

```bash
$ docker-compose run --rm cli-tests codecept run functional
```


### How to check coding standards?

```bash
$ docker-compose run --rm cs
```

To fix code alowed to be fixed using [PHP Code Beautifier and Fixer](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Fixing-Errors-Automatically).

```bash
$ docker-compose run --rm cs phpcbf
```
