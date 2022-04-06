<div class="form-group {{ $classformgroup }}">
    <label class="{{ $classlabel }} text-primary font-weight-bold text-uppercase mb-3">{{ $label }}</label>
    <div class="{{ $classinput }} form-check form-check-switchery form-check-switchery-double">
        <label class="form-check-label">
            {{ $textoff }}
        <input type="checkbox" name="{{ $name }}" class="form-check-input-switchery" {{ $checked }} data-fouc>
            {{ $texton }}
        </label>
    </div>
</div>
