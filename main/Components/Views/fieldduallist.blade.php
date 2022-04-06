<div class="form-group">
    <label class="{{ $classlabel }} text-primary font-weight-bold text-uppercase">{{ $label }}</label>
    <div class="{{ $classinput }}">
        <select multiple="multiple" name="{{ $name }}" class="form-control duallistbox" data-fouc data-search="{{__('messages.searchPlacehoderPermissions')}}" data-select="{{__('messages.selectPlacehoderPermissions')}}" data-clear-search="{{__('messages.clearSearchPlacehoderPermissions')}}" data-found="{{__('messages.foundBoxPermissions')}}">
            @foreach($items as $item)
                <option value="{{ $item[$itemindex] }}"
                    @if (in_array($item[$itemindex], $datapivot))
                        selected
                    @endif
                >
                    {{ $item[$itemtext] }}
                </option>
            @endforeach
        </select>
    </div>
</div>
