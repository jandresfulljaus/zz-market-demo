<div class="form-group">
    <label class="{{ $classlabel }} text-primary font-weight-bold text-uppercase">{{ $label }}</label>
    <div class="{{ $classinput }}">
        <div class="row">
            <div class="col-md-{{ $width1 }}">
                <input name="{{ $name1 }}" value="{{ $value1 }}" class="form-control" placeholder="{{ $placeholder1 }}" maxlength="{{$maxlength1}}">
            </div>

            <div class="col-md-{{ $width2 }}">
                <input name="{{ $name2 }}" value="{{ $value2 }}" class="form-control" placeholder="{{ $placeholder2 }}" maxlength="{{ $maxlength2 }}">
            </div>
        </div>
    </div>
</div>