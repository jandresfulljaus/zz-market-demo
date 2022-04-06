<div class="form-group">
    <label class="{{ $classlabel }} text-primary font-weight-bold text-uppercase">{{ $label }}</label>
    <div class="{{ $classinput }}">
        <input type="number" step="{{ $step }}" min="{{ $min }}" max="{{ $max }}" name="{{ $name }}" value="{{ $value }}" class="form-control" placeholder="{{ $placeholder }}" {{ $readonly }} />
    </div>
</div>
