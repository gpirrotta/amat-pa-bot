AMAT PAlermo Telegram BOT
=========

Installation
------------

Clone the github repo in your machine

``` bash
$ git clone https://github.com/gpirrotta/AmatPABot.git
$ cd AmatPABot
```

And run these two commands to install it:

``` bash
$ wget http://getcomposer.org/composer.phar
$ php composer.phar install
```

Now you can add the autoloader, and you will have access to the library:

``` php
<?php

require 'vendor/autoload.php';
```

You're done.

## Usage
Set and rename the **amat-config-blank** file you find in the config directory.

``` php
<?php


    use GP\AmatPABot\AmatPABot;

    $config = require __DIR__ . '/config/amat-config.php';


    $token = $config['token'];
    $dbDriver = $config['connection'][$config['source']];
    $connectionString = str_replace(['[DRIVER]', '[HOST]', '[PORT]', '[DATABASE]'], [$dbDriver['driver'], $dbDriver['host'], $dbDriver['port'], $dbDriver['database']], $dbDriver['PDOString']);
    $username = $dbDriver['username'];
    $password = $dbDriver['password'];

    $amatPABot = new AmatPABot($token, $connectionString, $username, $password);

    // In you use WebHook invoke the following method
    $amatPABot->withWebHook();

    $amatPABot->run();
```

## Requirements

- >= PHP 5.5


## Demo

* [@amatPABot] (https://telegram.me/amatPABot)

## TODO

* Add Tests :-( *Sorry, I know they must be written before the code, TDD dixit*

## Credits

* Giovanni Pirrotta <giovanni.pirrotta@gmail.com>

## License

AmatPABot is released under the MIT License. See the bundled LICENSE file for
details.



