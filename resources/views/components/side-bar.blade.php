<div class="hidden fixed inset-0 h-full w-full" x-data="{ open_sidebar: false }" @open_sidebar.window="open_sidebar = true">
    <!-- The sidebar -->
    <div
        x-cloak
        x-show="open_sidebar"
        x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="inset-0 md:w-1/2 z-50">

        <div x-data="{ loaded: false }" x-init="() => { loaded = true }" x-show="loaded" class="bg-neutral-600">
            <!-- Custom sidebar content -->
            {{$slot}}
            <!-- End custom sidebar content -->
        </div>

    </div>

    <!-- Sidebar Backdrop -->
    <div x-show="open_sidebar" class=" inset-0 backdrop-blur-md z-40" x-click="open_sidebar = false"> </div>
    <!-- End Sidebar Backdrop -->

</div>
