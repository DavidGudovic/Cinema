<?php

namespace App\Traits\Reporting;

use App\Enums\Period;
use App\Interfaces\CanReport;
use App\Traits\ChartModelBuilder;
use App\Traits\ColorPalette;
use Asantibanez\LivewireCharts\Models\BaseChartModel;

/**
 * Extension of the ChartModelBuilder trait, attempts implementing a strategy pattern to build the data for a chart model
 */
trait ReportChartBuilder
{
    use ChartModelBuilder, ColorPalette;

    protected Period $period = Period::WEEKLY;
    protected int $hall_id = 0;

    public function setPeriod(string $period): void
    {
        $this->period = Period::from($period);
    }

    public function setHall(int $hall_id): void
    {
        $this->hall_id = $hall_id;
    }

    /**
     *  Builds a chart model based on the given parameters, uses an implementation of the CanReport interface to get the data
     * @param string $title
     * @param CanReport $service
     * @param array|null $colors
     * @param string $chart_type
     * @param bool $animated
     * @return BaseChartModel
     */
    protected function buildReportChart(string $title, CanReport $service, string $chart_type, bool $animated = false, ?array $colors = null) : BaseChartModel
    {
        return $this->buildChartModel(
            title: $title,
            data: $service->getReportableDataByPeriod($this->period, $this->hall_id),
            colors: $colors ?? $this->colors,
            chart_type: $chart_type,
            animated: $animated,
        );
    }
}
