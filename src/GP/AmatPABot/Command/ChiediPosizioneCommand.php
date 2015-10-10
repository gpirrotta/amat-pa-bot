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
class ChiediPosizioneCommand extends GTFSCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "❷";


    /**
     * @var string Command Description
     */
    protected $description = "Chiede di inviare la posizione con la georeferenziazione";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $text = "Per conoscere le fermate AMAT più vicine a te clicca sulla graffetta (📎) e invia la tua posizione";

        $this->replyWithMessage($text);
    }

} 