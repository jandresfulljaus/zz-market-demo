@php
use Main\Auth\Models\Role;
        if(Auth::user()->isRoot()){
                $text = __('messages.orderManagementHome');
        }elseif(Auth::user()->isAdmin()){
                $text = __('messages.ordersDetailOrders');
        }else{
            //Si es User hago esto
                $text = __('messages.ordersDetailOrders');
        }
    $icons = [
        [
            "route" => 'products.products.list',
            "params" => Str::contains(auth()->user()->email, ',') ? 0 : null,
            "icon" => "icon-store2",
            "color" => "bg-secondary",
            "text" => __('messages.catalogManagementHome'),
            "button" => __('messages.seeMoreOrders'),
        ],
        [
            "route" => 'orders.orders.list',
            "params" => null,
            "icon" => "icon-pencil7",
            "color" => "bg-secondary",
            "text" => $text,
            "button" => __('messages.seeMoreOrders'),
        ],
        [
            "route" => 'products.price.createcatalog',
            "params" => null,
            "icon" => "icon-newspaper",
            "color" => "bg-secondary",
            "text" => __('messages.adminCreateInfoCagalogue'),
            "button" => __('messages.seeMoreOrders'),
        ],
    ];
@endphp

<div class="home-separator bg-secondary">{{__('messages.shortcutsHomePageSeparator')}}
    <i data-toggle="tooltip" class="fa fa-question-circle home-info" data-placement="top" title="Accesos mas usados"></i>
</div>

<div class="row p-0">
    @foreach($icons as $key => $icon)
        @can('access', $icon['route'])
            <div class="col-xs-12 col-sm-6 col-md-6 col-xl-4 ">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="{{ $icon['icon'] }} big-icon-2x text {{ $icon['color'] }} border {{ $icon['color'] }} border-3 rounded-round p-3 mb-3 mt-1"></i>
                        <h5 class="card-title">{{ $icon['text'] }}</h5>
                        <a href="{{ route($icon['route'], $icon['params'])}}" class="btn {{ $icon['color'] }} legitRipple">{{ $icon['button'] }}</a>
                    </div>
                </div>
            </div>
        @endcan
    @endforeach
</div>
