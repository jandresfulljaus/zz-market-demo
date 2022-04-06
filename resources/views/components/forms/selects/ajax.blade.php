<select
    class="form-control form-control-selectajax"
    name="{{ $name }}"
    data-fouc
    data-allow-clear="true"
    data-placeholder="{{ $placeholder }}"
    data-template="{{ $template }}"
    data-url="{{ $url }}"
    {{ $attributes }}
>
    <option></option>
    @if ($item !== null)
        <option value="{{ $item->$itemValueField }}" selected="selected">
            {{ $item->$itemTextField }}
        </option>
    @endif
</select>
