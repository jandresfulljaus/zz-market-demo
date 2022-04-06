<div class="form-group">
    <label class="{{ $classlabel }} text-primary font-weight-bold text-uppercase">{!!html_entity_decode($label)!!}</label>
    <div class="{{ $classinput }}">
        <select name="{{ $name }}" @if(!empty($id)) id="{{ $id }}" @endif class="form-control {{ $classselect }}" data-fouc data-template="{{ $template }}" {{ $disabled }}>
            @if($optionalText != null)
                <option value="">{{ $optionalText }}</option>
            @endif
            @foreach($items as $k => $item)
                @if(is_string($k))
                    <optgroup label="{{ $k }}">
                        @foreach($item as $k2 => $subitem)
                            <option value="{{ $subitem[$itemindex] }}"
                                @if ($subitem[$itemindex] == $value)
                                    selected
                                @endif
                                @if (!empty($datatags))
                                    @foreach ($datatags as $dtag)
                                        data-{{ $dtag }}="{{ $subitem[$dtag] }}"
                                    @endforeach
                                @endif
                            >
                                {{ $subitem[$itemtext] }}
                            </option>
                        @endforeach
                    </optgroup>
                @else
                    <option value="{{ $item[$itemindex] }}"
                        @if ($item[$itemindex] == $value)
                            selected
                        @endif

                        @if (!empty($datatags))
                            @foreach ($datatags as $dtag)
                                data-{{ $dtag }}="{{ $item[$dtag] }}"
                            @endforeach
                        @endif
                    >
                        {{ $item[$itemtext] }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>
</div>
