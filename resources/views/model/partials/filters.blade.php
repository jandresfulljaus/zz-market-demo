<div class="row">
    <div class="col-lg-6">
        <div class="control-group w-100">
            <div class="controls">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="mi-search"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" id="filtersearch" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        @isset($list->filters))
            <div class="control-group w-100">
                <div class="controls">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="mi-filter-list"></i>
                            </span>
                        </div>
                        <select style="width: 200px" id="filterlist" class="form-control select2">
                            <option value="0">- {{__('messages.allDataSelect')}} -</option>
                            @foreach ($list->filters as $filter)
                                <option value="{{ $filter->id }}">{{ $filter->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endisset
    </div>
    <div class="col-lg-1 hidden-xs"></div>
    <div class="col-lg-2">
        <div class="paginate_table pull-right"></div>
    </div>
</div>
