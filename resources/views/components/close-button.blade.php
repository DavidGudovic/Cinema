<!-- Close Modal Button -->
<a href="" {{ $attributes->merge(['class' => 'fa-solid fa-xmark fa-xl absolute']) }}
x-on:click.prevent="showModal = false; showSideBar = false; showModalSecond = false;"></a>
<!-- End Close button -->
