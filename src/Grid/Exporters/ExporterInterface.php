<?php

namespace Encore\Admin\Grid\Exporters;

interface ExporterInterface
{
    /**
     * Export data from grid.
     */
    public function export();
}
