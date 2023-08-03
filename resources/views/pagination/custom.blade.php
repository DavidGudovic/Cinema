@if ($paginator->hasPages())
  @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : $this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1)

  <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">

    <div class="flex-1 flex flex-col md:flex-row items-center justify-between">
      <!-- Text Showing # of # -->
      <div>
        <p class="text-sm text-white leading-5">
          <span>{!! __('Rezultati') !!}</span>
          <span class="font-medium">{{ $paginator->firstItem() }}</span>
          <span>{!! __('-') !!}</span>
          <span class="font-medium">{{ $paginator->lastItem() }}</span>
          <span>{!! __('od') !!}</span>
          <span class="font-medium">{{ $paginator->total() }}</span>
          <span>{!! __('ukupno') !!}</span>
        </p>
      </div>
      <!-- End text-->
      <!-- Page links -->
      <div>
        <span class="relative z-0 inline-flex ">
          <span>

            <!-- Previous page -->
            @if ($paginator->onFirstPage())
              <span class="relative inline-flex items-center px-2 py-2 text-white" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                <i class="fa-solid fa-angle-left"></i>
              </span>
            @else
              <button wire:click="previousPage('{{ $paginator->getPageName() }}')" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after" rel="prev"
                class="relative inline-flex items-center px-2 py-2  text-white  hover:text-red-700 focus:z-10 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                <i class="fa-solid fa-angle-left"></i>
              </button>
            @endif
          </span>
          <!-- End previous page -->

          <!--  Page numbers list-->
          @foreach ($elements as $element)

            <!-- Dot seperator after 11 pages, not customizable for some reason -->
            @if (is_string($element))
              <span aria-disabled="true" class="pt-1">
                ...
              </span>
            @endif
            <!-- End dot seperator -->

            @if (is_array($element))
              @foreach ($element as $page => $url)
                <span wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page{{ $page }}"  class="py-1 px-1">
                  <!-- Current -->
                  @if ($page == $paginator->currentPage())
                    <span aria-current="page">
                      <span class="text-white">{{ $page }}</span>
                    </span>
                  @else
                    <!-- 2 around current are dots -->
                    @if($page >= $paginator->currentPage()-2 && $page <= $paginator->currentPage()+2)
                      @if($page >= $paginator->currentPage()-1 && $page <= $paginator->currentPage()+1)
                        <span>..</span>
                      @endif
                    @else
                      <!-- Not Current, not around -->
                      <button class="hover:text-red-700" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                        {{ $page }}
                      </button>
                    @endif
                  @endif
                </span>
              @endforeach
            @endif
          @endforeach
          <!-- End page numbers list -->

          <span>
            <!-- Next page -->
            @if ($paginator->hasMorePages())
              <button wire:click="nextPage('{{ $paginator->getPageName() }}')" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after" rel="next"
                class="relative inline-flex items-center px-2 py-2  text-white  hover:text-red-700 focus:z-10 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                <i class="fa-solid fa-angle-right"></i>
              </button>
            @else
              <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                <span class="relative inline-flex items-center px-2 py-2 text-white" aria-hidden="true">
                  <i class="fa-solid fa-angle-right"></i>
                </span>
              </span>
            @endif
            <!-- End page -->
          </span>

        </span>
      </div>
      <!-- End page links -->
    </div>
  </nav>
@endif
</div>
