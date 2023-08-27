<?php

namespace App\Traits;

use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Asantibanez\LivewireCharts\Models\BaseChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;

trait ChartModelBuilder
{
    /**
     * @param string $title
     * @param array $data
     * @param array $colors
     * @param string $chart_type
     * @param bool $animated
     * @return BaseChartModel
     * Builds a chart model based on the given parameters
     */
    protected function buildChartModel(string $title, array $data, array $colors, string $chart_type, bool $animated = false): BaseChartModel
    {
        $chartModel = $this->pickChart($chart_type);
        $chartModel->setTitle($title);
        $chartModel->setAnimated($animated);
        $chartModel->setSmoothCurve();
        $chartModel->withGrid();
        $chartModel->setColors($colors);
        $chartModel->setXAxisVisible(true);

        $this->setData($chartModel, $data, $colors, $chart_type);

        return $chartModel;
    }

    /**
     * @param string $chart_type
     * @return BaseChartModel
     * Picks the chart model based on the given chart type
     */
    private function pickChart(string $chart_type) : BaseChartModel
    {
        return match($chart_type) {
            'area' => LivewireCharts::areaChartModel(),
            'pie' => LivewireCharts::pieChartModel(),
            'line' => LivewireCharts::lineChartModel(),
            'multi-line' => LivewireCharts::multiLineChartModel(),
        };
    }

    /**
     * @param BaseChartModel $chartModel
     * @param array $data
     * @param array $colors
     * @param string $chart_type
     * @return void
     * Sets the data for the chart model based on the given parameters
     */
    private function setData(BaseChartModel $chartModel, array $data, array $colors, string $chart_type) : void
    {
        match($chart_type) {
            'area', 'line' => $this->setSingleData($chartModel, $data),
            'pie' => $this->setPieData($chartModel, $data, $colors),
            'multi-line' => $this->setMultiData($chartModel, $data),
        };
    }

    /**
     * @param AreaChartModel|LineChartModel $chartModel
     * @param array $data
     * @return void
     * Sets the data for the area or line chart model
     */
    private function setSingleData(AreaChartModel|LineChartModel $chartModel, array $data) : void
    {
        foreach ($data as $key => $value) {
            $chartModel->addPoint($key, $value);
        }
    }

    /**
     * @param PieChartModel $chartModel
     * @param array $data
     * @param array $colors
     * @return void
     * Sets the data for the pie chart model
     */
    private function setPieData(PieChartModel $chartModel, array $data, array $colors) : void
    {
        foreach ($data as $key => $value) {
            $chartModel->addSlice($key, $value, $colors[$key]);
        }
    }

    /**
     * @param LineChartModel $chartModel
     * @param array $data
     * @return void
     * Sets the data for the multi line chart model
     */
    private function setMultiData(LineChartModel $chartModel, array $data) : void
    {
        foreach ($data as $key => $seriesData) {
            foreach($seriesData as $series => $value) {
                $chartModel->addSeriesPoint($series, $key, $value);
            }
        }
    }

}
