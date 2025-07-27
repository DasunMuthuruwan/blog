<div class="pagination_div">
    @if ($paginator->hasPages())
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <!-- Previous -->
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link" tabindex="-1"><i class="ti-arrow-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <button type="button" wire:click="previousPage" class="page-link" tabindex="-1">
                            <i class="ti-arrow-left"></i>
                        </button>
                    </li>
                @endif

                @if ($paginator->currentPage() > 3)
                    <li class="page-item">
                        <button type="button" wire:click="gotoPage(1)" class="page-link">1</button>
                    </li>
                @endif
                @if ($paginator->currentPage() > 4)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif

                @foreach (range(1, $paginator->lastPage()) as $i)
                    @if ($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                        @if ($i == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $i }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <button type="button" wire:click="gotoPage({{ $i }})" class="page-link">
                                    {{ $i }}
                                </button>
                            </li>
                        @endif
                    @endif
                @endforeach

                @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
                @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                    <li class="page-item">
                        <button type="button" wire:click="gotoPage({{ $paginator->lastPage() }})" class="page-link">
                            {{ $paginator->lastPage() }}
                        </button>
                    </li>
                @endif

                <!-- Next -->
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <button type="button" wire:click="nextPage" class="page-link">
                            <i class="ti-arrow-right"></i>
                        </button>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="ti-arrow-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>