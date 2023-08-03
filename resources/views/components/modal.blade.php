<!-- Modal -->
<div
  x-data="{ showModal: @entangle($attributes->wire('model')) }"
  x-show="showModal" x-trap.noscroll="showModal"
  x-on:keydown.escape.window="showModal = false"
  x-cloak
  class="flex justify-center fixed inset-0 px-4 py-6 md:py-24 z-50">
  <!-- Modal Background -->
  <div x-show="showModal" class="fixed inset-0 transform bg-gray-500 opacity-70 " x-on:click="showModal=false"></div>
  <!-- End modal background-->
  <!-- Custom Modal body -->
          {{ $slot }}
   <!-- End custom modal body -->
</div>
 <!--End modal -->
