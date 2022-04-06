<!-- <div class="form-group">
    <label class="{ { $classlabel }} text-primary font-weight-bold text-uppercase">{ { $label }}:</label>
    <div class="{ { $classinput }}">
        <select name="{ { $name }}" class="form-control select-multiple-tags" multiple="multiple" data-fouc>
            @ foreach($items as $item)
                <option value="{ { $item[$itemindex] }}"
                    @ if ($item[$itemindex] == $value)
                    selected
                    @ endif

                    @ if (! empty($datapivot))
                    @ foreach ($datapivot as $dtag)
                        data-{ { $dtag }}="{ { $item[$dtag] }}"
                    @ endforeach
                    @ endif
                >
                    { { $item[$itemtext] }}
                </option>
            @ endforeach
        </select>
    </div>
</div> -->

<div class="form-group">
    <label class="{{ $classlabel }} text-primary font-weight-bold text-uppercase">{{ $label }}</label>
    <div class="form-control {{ $classinput }}">
        <select multiple="multiple" name="{{ $name }}" class="form-control select-multiple-tags" data-fouc>
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
