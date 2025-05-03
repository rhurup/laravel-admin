<?php

namespace Rhurup\Admin\Grid\Exporters;

interface ExporterInterface
{
    /**
     * Export data from grid.
     */
    public function export();
}
