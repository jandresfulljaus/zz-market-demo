@php
    $icons = [
        [
            "icon" => "icon-file-plus",
            "color" => "bg-primary",
            "text" => __('messages.countOrdersDraft'),
            "value" => $showCardsInfo['ordersBOR']
        ],
        [
            "icon" => "icon-file-upload",
            "color" => "bg-primary",
            "text" => __('messages.countOrdersUnderReviewHome'),
            "value" => $showCardsInfo['ordersENV']
        ],
        [
            "icon" => "icon-file-check",
            "color" => "bg-primary",
            "text" => __('messages.countOrdersApprovedHome'),
            "value" => $showCardsInfo['ordersAPRO']
        ],
        [
            "icon" => "icon-file-empty",
            "color" => "bg-primary",
            "text" => __('messages.countOrdersHome'),
            "value" => $showCardsInfo['orders']
        ],
    ];
@endphp

<div class="home-separator bg-primary">{{__('messages.featuredMetricsHomePageSeparator')}}
    <i data-toggle="tooltip" class="fa fa-question-circle home-info" data-placement="top" title="Valores globales e históricos"></i>
</div>

<div class="row p-0">
    @foreach($icons as $key => $icon)
        <div class="col-xs-12 col-sm-6 col-md-6 col-xl-3 ">
            <div class="card">
                <div class="card-body text-center">
                    <i class="{{ $icon['icon'] }} big-icon-2x text {{ $icon['color'] }} border {{ $icon['color'] }} border-3 rounded-round p-3 mb-3 mt-1"></i>
                    <h5 class="card-title">{{ $icon['text'] }}</h5>
                    <h1>{{ $icon['value'] }}</h1>
                </div>
            </div>
        </div>
    @endforeach
</div>