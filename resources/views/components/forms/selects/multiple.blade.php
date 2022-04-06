<select
    class="form-control form-control-select2{{ ($template) ? '-custom-template' : ''}}"
    name="{{ $name }}"
    multiple
    data-fouc
    data-placeholder="{{ $placeholder }}"
    data-template="{{ $template }}"
    {{ $attributes }}
>
    @foreach ($items as $item)
        <option
            value="{{ $item->$itemValueField }}"
            {{ $isSelected($item->$itemValueField) ? 'selected="selected"' : '' }}
            @if (! empty($dataTags))
                @foreach ($dataTags as $tag)
                    data-{{ $tag }}="{{ $item->$tag }}"
                @endforeach
            @endif
        >
            {{ $item->$itemTextField }}
        </option>
    @endforeach
</select>
