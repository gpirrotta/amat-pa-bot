<?php

/**
 * This file is part of the AmatPABot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\AmatPABot;

use Telegram\Bot\Api;

use GP\AmatPABot\Command\StartCommand;
use GP\AmatPABot\Command\ChiediPosizioneCommand;
use GP\AmatPABot\Command\LineeAMATCommand;
use GP\AmatPABot\Command\OrariFerialeCommand;
use GP\AmatPABot\Command\FermataVicinaCommand;
use GP\AmatPABot\Command\InfoCommand;
use GP\AmatPABot\Repository\GTFSRepository;
use GP\AmatPABot\Exception\AmatPABotException;


/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class AmatPABot
{
    private $repository;
    private $telegram;
    private $webHook = false;

    public function __construct($token, $connectionString, $username, $password)
    {
        $this->repository = new GTFSRepository(new \PDO($connectionString, $username, $password));
        $this->telegram = new Api($token);

        $this->init();
    }

    private function init()
    {
        $this->telegram->addCommand(new StartCommand());
        $this->telegram->addCommand(new ChiediPosizioneCommand());
        $this->telegram->addCommand(new LineeAMATCommand($this->repository));
        $this->telegram->addCommand(new OrariFerialeCommand($this->repository));
        $this->telegram->addCommand(new FermataVicinaCommand($this->repository));
        $this->telegram->addCommand(new InfoCommand());
    }

    public function withWebHook()
    {
        $this->webHook = true;
    }

    public function run()
    {
        try {
            $this->telegram->commandsHandler($this->webHook);
        }
        catch(AmatPABotException $e) {
            // to implement Logger
            print $e->getMessage();
        }
       }
}