<?php

namespace App\Services;

use App\Models\Tool;

class StockService
{
    /**
     * Check if enough stock is available.
     *
     * @param int $toolId
     * @param int $qty
     * @return bool
     */
    public function checkStock($toolId, $qty)
    {
        $tool = Tool::find($toolId);
        
        if (!$tool) {
            return false;
        }

        return $tool->stock >= $qty;
    }

    /**
     * Decrement stock for a tool.
     *
     * @param int $toolId
     * @param int $qty
     * @return void
     */
    public function decrementStock($toolId, $qty)
    {
        $tool = Tool::find($toolId);
        if ($tool) {
            $tool->decrement('stock', $qty);
        }
    }

    /**
     * Increment stock for a tool.
     *
     * @param int $toolId
     * @param int $qty
     * @return void
     */
    public function incrementStock($toolId, $qty)
    {
        $tool = Tool::find($toolId);
        if ($tool) {
            $tool->increment('stock', $qty);
        }
    }
}
