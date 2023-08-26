<?php

namespace App\Http\Livewire\Admin\Screening;

use App\Models\Hall;
use App\Services\HallService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;

/**
 * Component for picking the dates and times of a screening
 * Due to unexpected behavior/timezone conversions after Livewire serializes Carbon objects
 * All date arrays are maintained as strings and passed to the view as such,
 * and then converted back into Carbon/CarbonPeriod objects when processed here.
 */
class DatePicker extends Component
{
    public Hall $hall;
    public int $movie_duration;
    public $dates = [];
    public $times = [];
    public $current_date;
    public $displayed_date;
    public $selected_dates = [];
    public $selected_times = [];
    public $unavailable_times = [];

    protected $listeners = [
        'clearDates' => 'clearDates',
        'hallPicked' => 'setHall',
    ];

    public function mount()
    {
        $this->movie_duration += config('settings.advertising.duration') * config('settings.advertising.per_screening');
        $this->current_date = Carbon::now();
        $this->displayed_date = $this->current_date->copy();
        $this->fetchDateMap();
    }

    public function render()
    {
        return view('livewire.admin.screening.date-picker');
    }

    /**
     * Validates and emits the selected dates and times to the parent component
     */
    public function pickDates(): void
    {
        $this->validate([
            'selected_dates' => 'required|array|min:1',
            'selected_times' => 'required|array|min:1',
        ]);

        $this->emit('datePicked', $this->selected_dates, $this->selected_times);
    }

    public function setHall(Hall $hall): void
    {
        $this->hall = $hall;
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
    public function isSelected(string $needle): bool
    {
        return in_array($needle, array_merge($this->selected_dates, $this->selected_times));
    }

    /**
     * Toggles the value in the selected array, re-fetches the time map
     */
    private function toggleValue(string $value, array &$array): void
    {
        $flippedArray = array_flip($array);
        if (isset($flippedArray[$value])) {
            unset($array[$flippedArray[$value]]);
        } else {
            $array[] = $value;
        }
        $this->fetchTimeMap();
    }

    public function toggleTime(string $time): void
    {
        $this->toggleValue($time, $this->selected_times);
    }

    public function toggleDate(string $date): void
    {
        $this->toggleValue($date, $this->selected_dates);
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
    public function fetchTimeMap(): void
    {
        $this->times = [];
        if (empty($this->selected_dates)) { // If all dates are deselected
            $this->selected_times = [];
            return;
        }

        $this->initializeTimeSlots();
        $this->fetchUnavailableTimesMap(new HallService());
        $this->removeIntersectWithSelected();
        $this->removeIntersectWithUnavailable();
    }

    /**
     * Removes the time slots from $time that are intersected by the $selected_times
     * Free | screening duration ---- selected time ---- screening duration | Free
     */
    private function removeIntersectWithSelected(): void
    {
        foreach ($this->selected_times as $selected_time) {
            $selectedCarbonTime = Carbon::createFromFormat('H:i', $selected_time);
            $this->times = array_filter($this->times, function ($time_slot) use ($selected_time, $selectedCarbonTime) {
                $timeSlotCarbon = Carbon::createFromFormat('H:i', $time_slot);
                $diffInMinutes = $selectedCarbonTime->diffInMinutes($timeSlotCarbon, true);

                return $time_slot === $selected_time || $diffInMinutes > $this->movie_duration;
            });
        }
    }

    /**
     * Removes the time slots from $time that are intersected by the $unavailable_times
     * Free | new screening duration ---- (start_time ---- end_time) | Free
     */
    private function removeIntersectWithUnavailable(): void
    {
        $this->times = $this->filterTimes($this->times);
        $this->selected_times = $this->filterTimes($this->selected_times);
    }

    /**
     * Filters the $selected_times or $times array by time intersect with the $unavailable_times
     */
    private function filterTimes(array $times): array
    {
        return array_filter($times, function ($time_slot) {
            $timeSlotCarbon = Carbon::createFromFormat('H:i', $time_slot);
            $nextTimeSlotCarbon = $timeSlotCarbon->copy()->addMinutes(15);

            foreach ($this->unavailable_times as $unavailableSlot) {
                list($start, $end) = $unavailableSlot;
                $startCarbon = Carbon::createFromFormat('H:i', $start);
                $intersectStartCarbon = $startCarbon->copy()->subMinutes($this->movie_duration); // A movie cannot be screened if it ends after the start of the unavailable time slot
                $endCarbon = Carbon::createFromFormat('H:i', $end);

                if ($timeSlotCarbon->lt($endCarbon) && $nextTimeSlotCarbon->gt($intersectStartCarbon)) {
                    return false;
                }
            }

            return true;
        });
    }

    /**
     * Sets $times to an array of 15 minute time slots between the opening and closing time
     * 10:00 - 10:15 - 10:30 - 10:45 - 11:00 etc.
     */
    private function initializeTimeSlots(): void
    {
        $start = Carbon::today()->setTime(config('settings.restrictions.opening_time'), 0, 0);
        $end = Carbon::today()->setTime(config('settings.restrictions.closing_time') - ($this->movie_duration / 60), 0, 0);
        $period = CarbonPeriod::create($start, config('settings.restrictions.screening_periods') . ' minutes', $end);

        $this->times = array_map(function ($time) {
            return $time->format('H:i');
        }, $period->toArray());
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

    /**
     * Fetches the unavailable times for the selected dates
     */
    public function fetchUnavailableTimesMap(HallService $hallService): void
    {
        $this->unavailable_times = [];
        $unavailableTimes = $hallService->getUnavailableTimeSlotsForDaysMap($this->selected_dates, $this->hall);

        $this->unavailable_times = array_map(function ($timeSlot) {
            return [
                $timeSlot[0]->format('H:i'),
                $timeSlot[1]->format('H:i'),
            ];
        }, $unavailableTimes);
    }

}
