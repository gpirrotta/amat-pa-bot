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
class OrariFerialeCommand extends GTFSCommandRepositoryAware
{
    const MAX_LENGTH = 4096;

    /**
     * @var string Command Name
     */
    protected $name = "🚌";

    /**
     * @var string Command Description
     */
    protected $description = "Visualizza gli orari feriali di una linea";

    protected $codiceOrariFeriali = "FR_merged_80003";



    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $parts = explode(" ", trim($arguments));
        $routeId = trim($parts[0]);

        $this->replyWithChatAction(Actions::TYPING);

        $output = $this->buildFermateOutput($routeId);

        $length = mb_strlen($output, 'UTF8');

        if ($length <= self::MAX_LENGTH) {
            $this->replyWithMessage($output);
        } else {
            $chunks = str_split($output, self::MAX_LENGTH);
            foreach($chunks as $chunk) {
                $this->replyWithMessage($chunk);
            }
        }

        $this->triggerCommand('start');
    }

    public function buildFermateOutput($routeId)
    {
        $partenze = array();
        $orari = array();
        $fermate = array();


        $orariFeriali = $this->repository->getBusTimeByRoute($routeId, $this->codiceOrariFeriali);

        foreach($orariFeriali as $trip) {
            $orari[trim($trip['trip_headsign'])][] = substr($trip['arrival_time'],0,5);
            $partenze[trim($trip['trip_headsign'])] = $trip['trip_id'];
        }

        foreach($partenze as $headsign => $trip_id) {
            $stops = $this->repository->getStopsByTrip($trip_id);

            foreach($stops as $stop) {
                $fermate[$headsign][] = $stop['stop_name'];
            }
        }

        $output = "";
        foreach($fermate as $headsign => $fermata) {
            $output.="🚩";
            foreach($fermata as $f) {
                $output.=$f. " ⇨ ";
            }
            $output = rtrim(trim($output), "⇨");
            $output.="🏁 ";

            $output.="\n\nOrari:\n";
            foreach($orari[$headsign] as $orario) {
                $output.=$orario." ";

            }
            $output = trim($output);

            $output.= "\n\n";
        }


        if ($output == "") {
            $output = "Mi dispiace, nessun orario trovato";
        }

        return $output;
    }

} 