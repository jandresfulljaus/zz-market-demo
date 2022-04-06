@extends('Admin.Views.admin')

@section('content')
    <div class="row">
        @if (!empty($showChangePassword))
            @include('Admin.Views.HomeWidgets.changePassword')
        @endif

        <div class="col-sm-12 col-lg-12">
            @include('Admin.Views.HomeWidgets.metrics', $showCardsInfo)
        </div>

        <div class="col-sm-12 col-lg-12">
            @include('Admin.Views.HomeWidgets.icons')
        </div>

    </div>
@endsection
