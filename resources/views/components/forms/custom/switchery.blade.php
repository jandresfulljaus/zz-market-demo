<div class="form-check form-check-switchery form-check-switchery-double">
    <label class="form-check-label">
        {{ $offLabel ?? 'No' }}
        <input
            class="form-check-input-switchery"
            type="checkbox"
            name="{{ $name }}"
            {{ $isChecked($value) ? 'checked' : '' }}
            data-fouc
        >
        {{ $onLabel ?? 'Si' }}
    </label>
</div>
