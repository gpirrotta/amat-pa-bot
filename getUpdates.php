<?php

/**
 * This file is part of the AmatPABot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */

//Show all errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

$config = require __DIR__ . '/config/amat-config-blank.php';

//This is suggested from Guzzle
date_default_timezone_set($config['timezone']);

$token = $config['token'];
$dbDriver = $config['connection'][$config['source']];
$connectionString = str_replace(['[DRIVER]', '[HOST]', '[PORT]', '[DATABASE]'], [$dbDriver['driver'], $dbDriver['host'], $dbDriver['port'], $dbDriver['database']], $dbDriver['PDOString']);
$username = $dbDriver['username'];
$password = $dbDriver['password'];

require 'vendor/autoload.php';

use GP\AmatPABot\AmatPABot;

$amatPABot = new AmatPABot($token, $connectionString, $username, $password);

// In you use WebHook invoke the following method
//$amatPABot->withWebHook();

try {
    $amatPABot->run();
}
catch(\Exception $e) {
    // to do logger
    print $e->getMessage();
}

unset($dbDriver);
