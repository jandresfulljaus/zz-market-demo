<div class="form-group">
    <label class="{{ $classlabel }} text-primary font-weight-bold text-uppercase">{{ $label }}</label>
    <div class="{{ $classinput }}">
        <input type="text" name="{{ $name }}" value="{{ $value }}" class="form-control" placeholder="{{ $placeholder }}" maxlength="{{ $maxlength }}" {{ $readonly }} />
    </div>
</div>
