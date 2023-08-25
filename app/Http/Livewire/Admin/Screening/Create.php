<?php

namespace App\Http\Livewire\Admin\Screening;

use App\Models\Hall;
use App\Models\Movie;
use App\Models\Tag;
use App\Services\BookingService;
use App\Services\RequestableService;
use App\Services\ScreeningService;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component
{
    public Movie $movie;
    public Collection $halls;
    public Collection $tags;
    public int $step = 1;
    public int $amount_created = 0;
    public int $bookings_cancelled_on_intersect = 0;

    public ?Hall $picked_hall;
    public ?Tag $picked_tag;
    public array $picked_dates = [];
    public array $picked_times = [];

    protected $listeners = [
        'backtrack' => 'backtrack',
        'datePicked' => 'submit',
    ];

    public function render()
    {
        return view('livewire.admin.screening.create');
    }

    /**
     * Submits the selected dates and times to the ScreeningService for a massCreate, and increments the step
     */
    public function submit(array $selected_dates, array $selected_times, ScreeningService $screeningService, RequestableService $requestableService, BookingService $bookingService) : void
    {
        $this->picked_dates = $selected_dates;
        $this->picked_times = $selected_times;

        [$this->amount_created, $this->bookings_cancelled_on_intersect] = $screeningService->massCreateScreenings(
            movie: $this->movie,
            hall: $this->picked_hall,
            tag: $this->picked_tag,
            selected_dates: $this->picked_dates,
            selected_times: $this->picked_times,
            bookingService: $bookingService,
            requestableService: $requestableService,
        );

        $this->step++;
    }

    public function setHall(Hall $picked_hall)
    {
        $this->picked_hall = $picked_hall;
        $this->step++;
        $this->emit('hallPicked', $picked_hall);
    }

    public function setTag(Tag $picked_tag)
    {
        $this->picked_tag = $picked_tag;
        $this->step++;
        $this->emit('tagPicked', $picked_tag);
    }

    public function clearDates() : void
    {
        $this->picked_dates = [];
        $this->picked_times = [];
        $this->emit('clearDates');
    }

    /**
     * Backtracks to the specified step, called by clicking on a step in the x-breadcrumbs component
     * Forgets the appropriate data based on the step
     */
    public function backtrack(int $step) : void
    {
        $actions = [
            3 => function() { $this->clearDates(); },
            2 => function() { $this->picked_tag = null; },
            1 => function() { $this->picked_hall = null; },
        ];

        foreach ($actions as $actionStep => $action) {
            if ($step <= $actionStep) {
                $action();
            }
        }

        $this->step = $step;
    }

}
