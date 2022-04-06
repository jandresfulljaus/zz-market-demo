<li class="nav-item">
    <a
        class="nav-link {{ $isActive }}"
        href="{{ $url }}"
        {{ $attributes }}
    >
        <i class="{{ $icon }}"></i>
        {{ $slot }}
    </a>
</li>
