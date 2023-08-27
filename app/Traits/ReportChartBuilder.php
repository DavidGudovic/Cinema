<?php

namespace App\Traits;

use App\Enums\Periods;
use App\Interfaces\CanReport;
use Asantibanez\LivewireCharts\Models\BaseChartModel;

trait ReportChartBuilder
{
    use ChartModelBuilder, ColorPalette;
    protected Periods $period = Periods::MONTHLY;
    protected int $hall_id = 0;

    protected function setPeriod(Periods $period): void
    {
        $this->period = $period;
    }

    protected function setHall(int $hall_id): void
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

    /**
     * @param Periods $period
     * @return string
     */
    protected function getDataFormat(Periods $period): string
    {
        return match ($period) {
            Periods::WEEKLY => 'd/m',
            Periods::MONTHLY => 'd/M',
            Periods::YEARLY => 'M',
        };
    }
}
