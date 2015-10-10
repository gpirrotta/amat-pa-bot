<?php

/**
 * This file is part of the AmatPABot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\AmatPABot\Command;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class InfoCommand extends GTFSCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "❔";

    /**
     * @var string Command Description
     */
    protected $description = "Informazioni BOT";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {

        $text = <<<BOT
AMAT Palermo BOT (Beta)
Informazioni linee, corse, orari e fermate del sistema
di trasporto pubblico AMAT a Palermo

Dati OpenData CC BY 4.0 IT
Fonte: http://www.comune.palermo.it/gtfs/amat_feed_gtfs_v7.zip
Anno 2015 - orari feriali

App non ufficiale, si declina ogni tipo di responsabilità

Autore: Giovanni Pirrotta
Home: giovanni.pirrotta.it
Mail: giovanni@pirrotta.it
Twitter: twitter.com/gpirrotta
BOT;

        $this->replyWithMessage($text);
        $this->triggerCommand('start');
   }
}