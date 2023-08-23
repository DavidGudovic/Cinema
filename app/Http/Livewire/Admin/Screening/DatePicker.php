<?php

namespace App\Http\Livewire\Admin\Screening;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;

class DatePicker extends Component
{
    public $dates = [];
    public $current_date;
    public $displayed_date;
    public $selected_dates = [];

    public $locale;


    protected $listeners = [
        'clearDates' => 'clearDates',
    ];

    public function mount()
    {
        $this->locale = app()->environment('production') ? 'sr_RS@latin' : 'sr_Latn_RS.UTF-8'; // 99% security flaw
        $this->current_date = Carbon::now();
        $this->displayed_date = $this->current_date->copy();
        $this->fetchDateMap();
    }

    public function render()
    {
        return view('livewire.admin.screening.date-picker');
    }

    public function clearDates(): void
    {
        $this->selected_dates = [];
        $this->displayed_date = $this->current_date->copy()->startOfMonth();
        $this->fetchDateMap();
    }

    public function isSelected($fullDate): bool
    {
        return in_array($fullDate, $this->selected_dates);
    }

    public function toggleDate(string $day): void
    {
        $dateToToggle = $this->displayed_date->copy()->setDate(
            $this->displayed_date->year,
            $this->displayed_date->month,
            $day
        )->format('Y-m-d');

        if (isset(array_flip($this->selected_dates)[$dateToToggle])) {
            unset($this->selected_dates[array_flip($this->selected_dates)[$dateToToggle]]);
        } else {
            $this->selected_dates[] = $dateToToggle;
        }
    }

    public function displayMonth(string $option): void
    {
        match ($option) {
            'current' => $this->displayed_date = $this->current_date->copy()->startOfMonth(),
            'next' => $this->displayed_date = $this->current_date->copy()->addMonthsNoOverflow(1)->startOfMonth(),
        };

        $this->fetchDateMap();
    }

    private function isInvalidDate(Carbon $date): bool
    {
        return $date->month != $this->displayed_date->month || $date < $this->current_date;
    }

    public function fetchDateMap(): void
    {
        $this->dates = [];
        $startOfWeek = $this->displayed_date->copy()->startOfMonth()->startOfWeek();
        $endOfWeek = $this->displayed_date->copy()->endOfMonth()->endOfWeek();
        $dates = CarbonPeriod::create($startOfWeek, '1 day', $endOfWeek);

        foreach ($dates as $date) {
            $this->dates[] = [
                'day' => $date->format('d'),
                'month' => $date->format('m'),
                'fullDate' => $date->format('Y-m-d'),
                'isInvalid' => $this->isInvalidDate($date),
            ];
        }
    }
}
