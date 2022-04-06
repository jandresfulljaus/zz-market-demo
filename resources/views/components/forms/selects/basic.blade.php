<select
    class="form-control form-control-select2{{ ($template) ? '-custom-template' : ''}}"
    name="{{ $name }}"
    data-fouc
    data-allow-clear="true"
    data-placeholder="{{ $placeholder }}"
    data-template="{{ $template }}"
    {{ $attributes }}
>
    <option></option>
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
