 <div class="flex flex-col w-full flex-1 gap-4 overflow-y-auto">

    <!-- Item -->
    <div class="flex flex-row justify-between border-b border-white gap-2">
        <!-- Left info-->
        <div class="flex flex-col gap-3">
            <span>Početak zakupa:</span>
        </div>
        <!-- Right info-->
        <div class="flex flex-row justify-between">
            <span class="text-sm">{{Carbon\Carbon::parse($request->requestable->start_time)->format('H:i m/d/Y')}}</span>
        </div>
        <!-- End info-->
    </div>
    <!-- End item -->

     <!-- Item -->
    <div class="flex flex-row justify-between border-b border-white gap-2">
        <!-- Left info-->
        <div class="flex flex-col gap-3">
            <span>Kraj zakupa:</span>
        </div>
        <!-- Right info-->
        <div class="flex flex-row justify-between">
            <span class="text-sm">{{Carbon\Carbon::parse($request->requestable->end_time)->format('H:i m/d/Y')}}</span>
        </div>
        <!-- End info-->
    </div>
    <!-- End item -->

      <!-- Item -->
    <div class="flex flex-row justify-between border-b border-white gap-2">
        <!-- Left info-->
        <div class="flex flex-col gap-3">
            <span>Sala:</span>
        </div>
        <!-- Right info-->
        <div class="flex flex-row justify-between">
            <span class="text-sm">{{$request->requestable->hall_id}} - {{$request->requestable->hall->name}}</span>
        </div>
        <!-- End info-->
    </div>
    <!-- End item -->
    <!-- Details -->
    <div class="flex flex-row h-full">
        <div class="flex flex-col w-full gap-2">
            <span>Tekst zahteva:</span>
            <span class="text-sm">{{$request->text}}</span>
        </div>
    </div>
    <!-- End details -->

</div>

