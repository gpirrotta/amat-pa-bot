<?php

/**
 * This file is part of the AmatPABot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\AmatPABot\Command;

use Telegram\Bot\Actions;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class FermataVicinaCommand extends GTFSCommandRepositoryAware
{
    /**
     * @var string Command Name
     */
    protected $name = "";

    /**
     * @var string Command Description
     */
    protected $description = "Visualizza le fermate più vicine alla propria posizione";


    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $parts = explode(" ", trim($arguments));
        $latitude = trim($parts[0]);
        $longitude = trim($parts[1]);

        $this->replyWithChatAction(Actions::TYPING);

        $stops = $this->repository->getNearestStops($latitude, $longitude);

        $first = array_shift($stops);

        $outputFermataVicina = $this->buildOutputFermataVicina($first, "La fermata più vicina è:\n");

        $outputAlfreFermate = $this->buildOutputAltreFermate($stops, "Altre fermate vicine:\n");

        $this->replyWithMessage($outputFermataVicina);
        $this->replyWithLocation($first['stop_lat'], $first['stop_lon']);
        $this->replyWithMessage($outputAlfreFermate);

        $this->triggerCommand('start');
    }


    private function getLineePerFermata($idFermata)
    {

        $routes = $this->repository->getRouteIdsByStop($idFermata);

        $linee = array();

        foreach($routes as $route) {
            $linee[] = $route['route_id'];
        }

        return $linee;
    }


    private function buildOutputAltreFermate($stops, $header="")
    {
        $output = $header;
        foreach($stops as $stop) {
            $output.= $this->buildOutputFermataVicina($stop);
        }

        return $output;
    }

    private function buildOutputFermataVicina($stop, $header = "")
    {
        $linee = $this->getLineePerFermata($stop['stop_id']);
        $outputLinee = $this->buildOutputLinee($linee);

        $outputFermataVicina = $header;
        $outputFermataVicina.= "🚏 ". $stop['stop_name'];
        $outputFermataVicina.= " ";
        $outputFermataVicina.="(km ". round($stop['distance'],2).")";
        $outputFermataVicina.= "\n";
        $outputFermataVicina.=$outputLinee;
        $outputFermataVicina.="\n";

        return $outputFermataVicina;
    }

    private function buildOutputLinee($linee)
    {
        $outputLinee = "(Linee: ";
        foreach($linee as $linea) {
            $outputLinee.=$linea.", ";
        }
        $outputLinee = rtrim(trim($outputLinee) ,",");
        $outputLinee.=")";

        return $outputLinee;
    }
}