<?php

/**
 * This file is part of the AmatPABot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\AmatPABot\Repository;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
interface GTFSRepositoryInterface
{
    public function getRoutes();

    public function getNearestStops($latitude, $longitude);

    public function getRouteIdsByStop($stopId);

    public function getBusTimeByRoute($routeId, $serviceId);

    public function getStopsByTrip($tripId);

} 