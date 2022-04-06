<div class="form-group">
    <label class="{{ $classlabel }} text-primary font-weight-bold text-uppercase">{{ $label }}</label>
    <div class="{{ $classinput }}">
        <textarea class="form-control" @isset($rows) rows="{{ $rows }}" @endisset name="{{ $name }}">{{ $value }}</textarea>
    </div>
</div>
