@props(['modal' => 'showModal'])
<!-- Close Modal Button -->
<a href="" {{ $attributes->merge(['class' => 'fa-solid fa-xmark fa-xl absolute']) }}
x-on:click.prevent="showSideBar = false; showModalSecond = false; {{$modal}} = false;"></a>
<!-- End Close button -->
