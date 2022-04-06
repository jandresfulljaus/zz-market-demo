@extends('Admin.Views.admin')
@include('orders::sidebar')

@php
$host = request()->getHttpHost();
$createOrderButton = ["type" => "link-custom", "icon" =>"mi-add","icon_class" =>"btn-success btn-link btn-float font-size-sm font-weight-semibold", "route"=> '//'.$host.'/orders/nuevo/orden?organization_id=replace_me'];

@endphp

@section('content')
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">{{ __('messages.selectOrganizationToCreateOrder')}}</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>
        <div class="card-body">
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
                                <input type="text" class="form-control" id="filtersearch" placeholder="{{ __('messages.searchPlaceholderUser')}}" aria-label="Buscar" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="control-group w-100">
                        <div class="controls">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="mi-filter-list"></i>
                                    </span>
                                </div>
                                <select id="filterlist" class="form-control select2">
                                    <option value="0">- {{__('messages.allDataSelect')}} -</option>
                                      @foreach ($data as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                      @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 hidden-xs"></div>
                <div class="col-lg-2">
                    <div class="paginate_table pull-right"></div>
                </div>
            </div>
        </div>
        <div class="table-responsive" id="table-list-2" noData="{{__('messages.noDataForSelection')}}">
            <table class="table" id="table-list" data-active="{{__('messages.statusActive')}}" data-inactive="{{__('messages.statusInactive')}}">
                <thead>
                    <tr>
                        @foreach($model_info->heads_fields[app()->getLocale()] as $i => $column_name)
                            <th>
                                @if(@$model_info->ordenable_fields[$i])
                                    <div class="input-group mb-0">
                                        <div id="pointer-{{ $i }}" data-column="{{ $i }}" data-field='{{ $model_info->list_fields[$i] }}' data-order='ASC' class="input-group-prepend pointer order">
                                            <i id="icon-{{ $i }}" class="mi-unfold-more"></i>
                                        </div>
                                        <p class="pl-2 m-0">  {{ $column_name }}</p>
                                    </div>
                                @else
                                    {{ $column_name }}
                                @endif
                            </th>
                        @endforeach
                        <th>{{__('messages.actionsBoxUser')}}</th>
                    </tr>
                </thead>
                <tbody class="sorted_table" id="sortable-data" data-page="{{__('messages.pageList')}}"></tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12">
                    <div class="paginate_table_footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        @if($model_info->sort!='')
            var AjaxSortingURL = '{{ route($model_info->routes["sort"]) }}';
        @endif
        var idpage = 1;

        var model_info = @json($model_info);
        
        var _token = '{{ csrf_token() }}';
        var route_getdata = '{{ route($model_info->routes['mygetdata']) }}';

        if (document.location.protocol == 'https:') {
            route_getdata = route_getdata.replace('http:', 'https:');
        }

        var ordinal_field = model_info["ordinal_field"];
        var ordinal_order = model_info["ordinal_order"];
        var listfields = model_info["list_fields"];
        var sort_field = model_info["sort"];
        console.log(model_info);
        model_info['actions'] = {};
        model_info['actions'].create = @json($createOrderButton);
        console.log(model_info);

        $(document).ready(function() {
            $('#datatables').show();

            Fulljaus.refreshData();

            $('#filtersearch').on('input',function(){
                Fulljaus.searchData();
            });

            $('.order').on('click',function(){
                i = $(this).attr('data-column');
                ordinal_field = $(this).attr('data-field');
                ordinal_order = $(this).attr('data-order');
                $('th').each(function(k){
                    if($('#icon-'+k) !== 'undefined' && i != k) {
                        $('#icon-'+k).attr('class','mi-unfold-more');
                    }
                });

                if(ordinal_order == 'DESC') {
                    $(this).attr('data-order', 'ASC');
                    $('#icon-'+i).attr('class', 'mi-keyboard-arrow-down text-danger');
                } else {
                    $(this).attr('data-order', 'DESC');
                    $('#icon-'+i).attr('class', 'mi-keyboard-arrow-up text-danger');
                }

                Fulljaus.refreshData();
            });

            @if(isset($model_info->filter))
                $('#filterlist').on('change', function() {
                    $('#exportToExcel').attr("href","{{ route($model_info->routes['sheet']) }}/?filter_id="+$(this).val());
                    Fulljaus.refreshData();
                    $(this).blur();
                });
            @endif
        });
    </script>
@endpush