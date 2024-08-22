@if ($paginator->hasPages())
    <!-- Pagination -->
    <div class="flex justify-center align-center">
      @if ($paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}" class="disabled">
                  <svg xmlns="http://www.w3.org/2000/svg" width="48" height="38" viewBox="0 0 48 38">
                      <g transform="translate(-877.5 -600)">
                          <path d="M-19057.816-16469.5l-5,5,5,5" transform="translate(19961.816 17083)" fill="none" stroke="#000" stroke-width="1"></path>
                          <rect width="48" height="38" transform="translate(877.5 600)" fill="none"></rect>
                      </g>
                  </svg></a>
            @else
            <a href="{{ $paginator->previousPageUrl() }}">
               <svg xmlns="http://www.w3.org/2000/svg" width="48" height="38" viewBox="0 0 48 38">
                   <g transform="translate(-877.5 -600)">
                       <path d="M-19057.816-16469.5l-5,5,5,5" transform="translate(19961.816 17083)" fill="none" stroke="#000" stroke-width="1"></path>
                       <rect width="48" height="38" transform="translate(877.5 600)" fill="none"></rect>
                   </g>
               </svg></a>
            @endif
      
            <ol class="flex justify-center align-center">
                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                            <li class="xans-record-"><a class="this">{{ $page }}</a></li>
                            @else
                            <li class="xans-record- "><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
         </ol>
         @if ($paginator->hasMorePages())
         <li class="page-item">
             <a href="{{ $paginator->nextPageUrl() }}">
               <svg xmlns="http://www.w3.org/2000/svg" width="48" height="38" viewBox="0 0 48 38">
                  <g transform="translate(-540 -859)">
                      <path d="M-19062.814-16469.5l5,5-5,5" transform="translate(19624.314 17342)" fill="none" stroke="#000" stroke-width="1"></path>
                      <rect width="48" height="38" transform="translate(540 859)" fill="none"></rect>
                  </g>
              </svg>
             </a>
         </li>
     @else
             
     @endif
      </div>
    <!-- Pagination -->
@endif
