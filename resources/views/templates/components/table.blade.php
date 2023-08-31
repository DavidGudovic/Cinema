<div class="flex flex-col justify-center items-center gap-4 h-full w-full mb-6">
    <!-- Actions -->
    <div class="flex flex-col md:flex-row justify-between items-center w-full mb-12 md:mb-4 text-sm md:text-base">

        <!-- Filters -->
        <div class="flex gap-4">
            @yield('left_filters')
        </div>
        <!-- End filters -->

        <!-- Load indicator MD -->
        <div wire:loading class="mt-4 absolute top-40  md:top-0 md:relative">
            <i class="fa-solid fa-gear fa-lg animate-spin"></i>
        </div>
        <!-- End load indicator -->

        <!-- Buttons and Search -->
        <div x-data="{showExcelDropdown: false, showAddDropdown: false}" class="flex gap-4">
            @yield('right_filters')
        </div>
        <!-- End buttons search -->

        <!-- Responsive third row -->
        <div x-data="{showAddDropdown: false}" class="flex justify-between w-full md:hidden px-4">
            @yield('responsive_filters')
        </div>
        <!-- End responsive third row -->
    </div>
    <!-- End actions -->


    <!-- Table -->
    <div class="flex flex-1 w-full text-white">
        <div class="w-screen md:w-auto min-w-fit md:overflow-x-hidden overflow-x-scroll">
            <table x-data="{ sortBy: @entangle('sort_by') }"
                   class="w-max md:w-full table-fixed md:overflow-x-hidden overflow-y-hidden overflow-x-auto">
                <thead class="">
                <tr>
                    @yield('table_header')
                </tr>
                </thead>
                <tbody x-data="{visibleToolTip: false, toolTipIndex: 0}">
                @yield('table_body')
                </tbody>
            </table>
        </div>
    </div>
    <!-- End table-->
    <p>@yield('pagination')</p>
    <!-- Delete modal-->
    @yield('modals')
</div>

