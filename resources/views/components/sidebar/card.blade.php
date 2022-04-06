<div class="card {{ $isActive ? '' : 'card-collapsed' }}">
    <div class="card-header bg-transparent header-elements-inline">
        <span class="text-uppercase font-size-sm font-weight-semibold">
            {{ $title }}
        </span>
        <div class="header-elements">
            @if ($badge !== null)
                <span class="badge badge-danger {{ $badge }}"></span>
            @endif
            <div class="list-icons">
                <a
                    class="list-icons-item @unless ($isActive) rotate-180 @endunless"
                    data-action="collapse"
                >
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0" @unless ($isActive) style="display:none;" @endunless>
        {{ $slot }}
    </div>
</div>
