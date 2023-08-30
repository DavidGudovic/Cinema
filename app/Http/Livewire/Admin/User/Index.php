<?php

namespace App\Http\Livewire\Admin\User;

use App\Enums\Roles;
use App\Http\Livewire\Admin\TableBase;
use App\Services\ExportService;
use App\Services\Resources\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Index extends TableBase
{
    /* User specific filter properties */
    public string $role = '';
    public string $is_verified = ''; // 'true' or 'false' String cause of livewire serialization
    public function render(UserService $userService)
    {
        $users = $this->getUserList($userService);

        if ($this->global_sort == 'false') {
            $this->sortDisplayedPaginatorCollection($users);
        }
        return view('livewire.admin.user.index', [
            'users' => $users,
            'roles' => collect(Roles::cases())->mapWithKeys(fn ($role) => [$role->name => $role->toSrLatinString()])
        ]);
    }

    /**
     * Returns a paginated, filtered list of users or a searched through list of users if $this->search_query is set
     */
    public function getUserList(UserService $userService): LengthAwarePaginator|Collection
    {
        return $userService->getFilteredUsersPaginated();
    }

    /**
     * Exports the user list to a CSV file
     * Returns a StreamedResponse with the CSV file
     * The CSV file is generated by the ExportService
     */
    public function export(ExportService $exportService, UserService $userService, string $scope = 'displayed'): StreamedResponse
    {
        $data = ($scope == 'displayed')
            ? $this->getUserList($userService)->values()->toArray()
            : $userService->getFilteredUsersPaginated();

        $csv = $exportService->generateCSV($data, $userService);

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'korisnici' . now()->format('-d:m:Y') . '.csv');
    }

}
