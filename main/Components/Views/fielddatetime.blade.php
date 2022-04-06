<div class="form-group">
    <label class="{{ $classlabel }} text-primary font-weight-bold text-uppercase">{{ $label }}</label>
    <div class="{{ $classinput }} row" style="position:relative;">
        <div class="col-6">
            <input type="date" name="{{ $name }}" value="{{ $date }}" class="form-control" />
        </div>
        <div class="col-6">
            <input type="time" name="{{ $name.'time' }}" value="{{ $time }}" class="form-control" />
        </div>
    </div>
</div>
