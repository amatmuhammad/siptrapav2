<?php

namespace App\Helpers;

class AStar
{
    protected $graph;
    protected $nodes;

    public function __construct($graph, $nodes)
    {
        $this->graph = $graph;
        $this->nodes = $nodes;
    }

    public function heuristic($a, $b)
    {
        $nodeA = $this->nodes[$a];
        $nodeB = $this->nodes[$b];

        $lat1 = deg2rad($nodeA->lat);
        $lon1 = deg2rad($nodeA->lng);
        $lat2 = deg2rad($nodeB->lat);
        $lon2 = deg2rad($nodeB->lng);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat/2)**2 + cos($lat1) * cos($lat2) * sin($dlon/2)**2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $earth_radius = 6371; // in KM

        return $earth_radius * $c;
    }

    public function findPath($start, $goal)
    {
        $openSet = new \SplPriorityQueue();
        $openSet->insert($start, 0);

        $cameFrom = [];
        $gScore = [];
        $fScore = [];

        foreach ($this->nodes as $key => $node) {
            $gScore[$key] = INF;
            $fScore[$key] = INF;
        }

        $gScore[$start] = 0;
        $fScore[$start] = $this->heuristic($start, $goal);

        while (!$openSet->isEmpty()) {
            $current = $openSet->extract();

            if ($current === $goal) {
                return $this->reconstructPath($cameFrom, $current);
            }

            if (!isset($this->graph[$current])) continue;

            foreach ($this->graph[$current] as $neighbor) {
                $tentativeG = $gScore[$current] + $neighbor['cost'];

                if ($tentativeG < $gScore[$neighbor['to']]) {
                    $cameFrom[$neighbor['to']] = $current;
                    $gScore[$neighbor['to']] = $tentativeG;
                    $fScore[$neighbor['to']] = $tentativeG + $this->heuristic($neighbor['to'], $goal);

                    $openSet->insert($neighbor['to'], -$fScore[$neighbor['to']]); // minus = lowest fScore first
                }
            }
        }

        return []; // tidak ada rute
    }

    private function reconstructPath($cameFrom, $current)
    {
        $totalPath = [$current];
        while (isset($cameFrom[$current])) {
            $current = $cameFrom[$current];
            array_unshift($totalPath, $current);
        }
        return $totalPath;
    }
}
