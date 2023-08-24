<?php

namespace App\Http\Livewire\Admin\Screening;

use App\Models\Movie;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;

class DatePicker extends Component
{
    public int $movie_duration;
    public $dates = [];
    public $times = [];
    public $current_date;
    public $displayed_date;
    public $selected_dates = [];
    public $selected_times = [];

    public $locale;


    protected $listeners = [
        'clearDates' => 'clearDates',
    ];

    public function mount()
    {
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
        $this->selected_times = [];
        $this->times = [];
        $this->fetchDateMap();
    }

    /**
     * Checks if the date or time (needle) is in the selected dates or times array (haystack)
     */
    public function isSelected($needle): bool
    {
        return in_array($needle, array_merge($this->selected_dates, $this->selected_times));
    }

    /**
     * Toggles the time in the selected times array, re-fetches the time map
     */
    public function toggleTime(string $time): void
    {
        if (isset(array_flip($this->selected_times)[$time])) {
            unset($this->selected_times[array_flip($this->selected_times)[$time]]);
        } else {
            $this->selected_times[] = $time;
        }
    }

    /**
     * Toggles the date in the selected dates array, re-fetches the time map
     */
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

        $this->fetchTimeMap();
    }

    /**
     * Displays the previous or next month 'current' or 'next'
     */
    public function displayMonth(string $option): void
    {
        match ($option) {
            'current' => $this->displayed_date = $this->current_date->copy()->startOfMonth(),
            'next' => $this->displayed_date = $this->current_date->copy()->addMonthsNoOverflow(1)->startOfMonth(),
        };

        $this->fetchDateMap();
    }

    /**
     * Checks if the date is invalid
     */
    private function isInvalidDate(Carbon $date): bool
    {
        return $date->month != $this->displayed_date->month || $date < $this->current_date;
    }

    /**
     * Fetches the time map for the selected dates
     */
    public function fetchTimeMap() : void
    {
        $this->times = [];
        foreach ($this->selected_dates as $date) {
            $start = Carbon::parse($date)->setTime(8, 0, 0);
            $end = Carbon::parse($date)->setTime(23, 0, 0);
            $times = CarbonPeriod::create($start, '30 minutes', $end);
            foreach ($times as $time) {
                $this->times[] = $time->format('H:i');
            }
        }
    }
    /**
     * Fetches the date map for the current month includes the trailing and leading days (start, end of week of prev/next month)
     */
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
