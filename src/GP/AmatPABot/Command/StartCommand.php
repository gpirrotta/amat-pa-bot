<?php

/**
 * This file is part of the AmatPABot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\AmatPABot\Command;

use GP\AmatPABot\Command\GTFSCommand;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class StartCommand extends GTFSCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "AmatPABot Palermo Menu";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {

        $keyboard = [
            ['❶   Orario Linee','❷  Fermata più vicina'],
            ['❔ Informazioni']
        ];

        $reply_markup = $this->telegram->replyKeyboardMarkup($keyboard, true, true);

        $this->replyWithMessage('Ciao, che informazioni desideri?', false, null, $reply_markup);

    }
}