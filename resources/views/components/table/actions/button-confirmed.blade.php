@props(['icon', 'route',
'enabled' => true,
'method' => 'POST',
'method_overload' => 'POST',
'title' => 'Potvrdite akciju',
'message' => 'Da li ste sigurni da želite da izvršite ovu akciju?',
'name' => 'showConfirmationModal'])

@if($enabled)
    <div x-data="{ {{$name}} : false }">
        <button {{$attributes->merge(['class'])}} x-on:click="{{$name}} = true">
            {{$icon}}
        </button>

        <!-- Modal -->
        <div x-show="{{$name}}" x-trap.noscroll="{{$name}}"
             x-on:keydown.escape.window="{{$name}} = false" x-cloak
            {{ $attributes->class(['flex justify-center items-center h-full fixed inset-0 px-4 py-6 md:py-6 z-50']) }}>
            <!-- Modal Background -->
            <div x-show="{{$name}}" class="fixed inset-0 transform backdrop-blur-sm" x-on:click="{{$name}}=false"></div>
            <!-- Modal body -->
            <div class="relative rounded-2xl bg-neutral-800 p-4 z-20 text-white">
                <x-close-button :modal="$name" class="top-5 left-4"/>
                <p class="text-xl text-center font-bold">{{$title}}</p>
                <p class="text-center mt-4">{{$message}}</p>
                <form method="POST" action="{{$route}}">
                    @csrf
                    @method($method_overload)
                    <button class="mt-2 w-full p-2 rounded-2xl cursor-pointer hover:text-red-700" type="submit">
                        {{$slot}}
                    </button>
                </form>
            </div>
            <!-- Modal body -->
        </div>
        <!-- End Modal -->
    </div>
@else
    <a href="#" aria-disabled="true" class='opacity-50 cursor-default text-red-700'>
        {{$icon}}
    </a>
@endif

