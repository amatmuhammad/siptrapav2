<?php

namespace App\Helpers;

class MinHeap {
    protected $queue = [];

    public function insert($value, $priority) {
        $this->queue[] = ['val' => $value, 'priority' => $priority];
        usort($this->queue, fn($a, $b) => $a['priority'] <=> $b['priority']);
    }

    public function extract() {
        return array_shift($this->queue)['val'] ?? null;
    }

    public function isEmpty() {
        return count($this->queue) === 0;
    }
}
