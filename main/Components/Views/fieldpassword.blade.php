<div class="form-group">
    <label class="{{ $classlabel }} text-primary font-weight-bold text-uppercase">{{ $label }}</label>
    <div class="{{ $classinput }}">
        <input type="password" name="{{ $name }}" value="{{ $value }}" class="form-control" placeholder="{{ $placeholder }}"
        @if(!empty($autocomplete))
        autocomplete="{{ $autocomplete }}"
        @endif
        />
    </div>
</div>
