<?php

namespace App\Helpers;

use App\Helpers\AStar;

class YenAlgorithm
{
    protected $graph;
    protected $nodes;
    protected $astar;

    public function __construct($graph, $nodes)
    {
        $this->graph = $graph;
        $this->nodes = $nodes;
        $this->astar = new AStar($graph, $nodes);
    }

    public function getKShortestPaths($start, $end, $k = 3)
    {
        $paths = [];
        $potentialPaths = [];

        $paths[] = $this->astar->findPath($start, $end);

        for ($i = 1; $i < $k; $i++) {
            $previousPath = $paths[$i - 1];

            for ($j = 0; $j < count($previousPath) - 1; $j++) {
                $spurNode = $previousPath[$j];
                $rootPath = array_slice($previousPath, 0, $j + 1);

                $tempGraph = $this->cloneGraph($this->graph);

                // Hapus edge dari graph yang menyebabkan siklus dengan rootPath
                foreach ($paths as $p) {
                    if (array_slice($p, 0, $j + 1) === $rootPath) {
                        $from = $p[$j];
                        $to = $p[$j + 1];

                        if (isset($tempGraph[$from])) {
                            $tempGraph[$from] = array_filter($tempGraph[$from], fn($e) => $e['to'] !== $to);
                        }
                    }
                }

                $spurPath = (new AStar($tempGraph, $this->nodes))->findPath($spurNode, $end);

                if (!empty($spurPath)) {
                    $totalPath = array_merge($rootPath, array_slice($spurPath, 1));
                    $potentialPaths[] = $totalPath;
                }
            }

            if (empty($potentialPaths)) break;

            usort($potentialPaths, fn($a, $b) => count($a) <=> count($b));

            $paths[] = array_shift($potentialPaths);
        }

        return $paths;
    }

    private function cloneGraph($graph)
    {
        return json_decode(json_encode($graph), true); // clone deep copy
    }
}
