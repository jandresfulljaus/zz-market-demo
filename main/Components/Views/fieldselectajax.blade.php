<div class="form-group">
    <label class="{{ $classlabel }} text-primary font-weight-bold text-uppercase">{{ $label }}</label>
    <div class="{{ $classinput }}">
    <select name="{{ $name }}" data-url="{{ $itemsurl }}" data-template="{{ $template }}" class="form-control form-control-selectajax" data-fouc>
            <option value="{{ $value }}" selected="selected">{{ $selected }}</option>
        </select>
    </div>
</div>