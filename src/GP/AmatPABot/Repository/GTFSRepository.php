<?php

/**
 * This file is part of the AmatPABot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\AmatPABot\Repository;

use GP\AmatPABot\Repository\GTFSRepositoryInterface;
use GP\AmatPABot\Exception\AmatPABotException;


/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class GTFSRepository implements GTFSRepositoryInterface
{
    private $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }
    
    public function getRoutes()
    {
        $sql = "select * from routes order by route_id asc";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\Exception $e) { // TO DO: Customize Exception
           throw new AmatPABotException($e);
        }

        return $results;

    }

    public function getNearestStops($latitude, $longitude)
    {
        $sql ="SELECT stop_id, stop_name, stop_lat, stop_lon,
       ( 6371 * acos( cos( radians(:latitude)) *
                      cos( radians( stop_lat )) *
                      cos( radians( :longitude ) -
                      radians(stop_lon)) +
                      sin( radians(:latitude))
                      * sin(radians(stop_lat)))) AS distance
               FROM stops
               HAVING distance < 250000
               ORDER BY distance limit 5";


        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':latitude', $latitude);
            $stmt->bindParam(':longitude', $longitude);
            $stmt->execute();
            $results =  $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\Exception $e) {
            throw new AmatPABotException($e);
        }

        return $results;
    }

    public function getRouteIdsByStop($stopId)
    {
        $sql = "select route_id
                 from stops, stop_times, trips
                 where stops.stop_id=stop_times.stop_id
                 and stop_times.trip_id = trips.trip_id
                 and stops.stop_id = :stop_id
                 group by route_id";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':stop_id', $stopId);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        // TO DO: Exception Customization
        catch(\Exception $e) {
            throw new AmatPABotException($e);
        }

        return $results;

    }


    public function getBusTimeByRoute($routeId, $serviceId)
    {
        $sql = "select * from stop_times, trips where stop_times.trip_id = trips.trip_id and trips.route_id = :route_id and service_id = :service_id  group by stop_times.trip_id order by departure_time asc";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':route_id', $routeId);
            $stmt->bindParam(':service_id', $serviceId);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\Exception $e) {
            throw new AmatPABotException($e);
        }

        return $results;

    }


    public function getStopsByTrip($tripId)
    {
        $sql = "select stop_name, trip_id
                from stop_times, stops
                where stops.stop_id = stop_times.stop_id
                and stop_times.trip_id = :trip_id
                order by stop_sequence";

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':trip_id', $tripId);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\Exception $e) {
            throw new AmatPABotException($e);
        }

        return $results;
    }
} 