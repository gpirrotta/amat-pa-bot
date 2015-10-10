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
class LineeAMATCommand extends GTFSCommandRepositoryAware
{
    /**
     * @var string Command Name
     */
    protected $name = "❶";


    /**
     * @var string Command Description
     */
    protected $description = "Visualizza tutte le linee AMAT di Palermo";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $routes = $this->repository->getRoutes();

        $response = array();

        foreach($routes as $route) {
            $response[] = array("🚌" ."   ".$route['route_id']." - ". $route['route_long_name']);
        }

        $reply_markup = $this->telegram->replyKeyboardMarkup($response, true, true);

        $this->replyWithMessage('Scegli una linea',false, null, $reply_markup);
    }

} 