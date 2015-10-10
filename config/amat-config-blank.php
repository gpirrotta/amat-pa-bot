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

return [
    // Telegram TOKEN
    'token' => 'YOUR TELEGRAM TOKEN',
    //Source of strings
    'source' => 'mysql',
    //Database connection credentials
    'connection' => [
        //Example connection and schema for MySQL
        'mysql' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'database', // amat_pa_2015
            'username' => 'username',
            'password' => 'password',
            'PDOString' => '[DRIVER]:host=[HOST];port=[PORT];dbname=[DATABASE]',
            //Set the value as null if you don't want this
            'driver_options' => [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'],
            //This will be the method that will be used in ORDER BY statement in SQL.
        ],
        //Example connection and schema for Postgres
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => '127.0.0.1',
            'port' => '5432',
            'database' => 'database',
            'username' => 'user',
            'password' => 'password',
            'PDOString' => '[DRIVER]:host=[HOST];port=[PORT];dbname=[DATABASE]',
            //Set the value as null if you don't want this
            'driver_options' => null, //Postgres comes with UTF-8 as default 
            //This will be the method that will be used in ORDER BY statement in SQL.
        ],
    ],
    //The timezone setting, Guzzle suggests having this for proper requests/responses
    'timezone' => 'Europe/Rome',
    //If no response is found, this will be used as response
    'default_fallback_response' => 'Non ho capito scusa, puoi ripetere?',
];