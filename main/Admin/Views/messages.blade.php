@if ($errors->any())
    <div class="row">
        <div class="col-12">
            @foreach ($errors->all() as $error)
                <x-alert type="danger">{{ $error }}</x-alert>
            @endforeach
        </div>
    </div>
@endif

@if (session('error'))
    <div class="row">
        <div class="col-12">
            <x-alert type="danger">{{ session('error') }}</x-alert>
        </div>
    </div>
@endif

@if (session('success'))
    <div class="row">
        <div class="col-12">
            <x-alert type="success">{{ session('success') }}</x-alert>
        </div>
    </div>
@endif

@if (session('warning'))
    <div class="row">
        <div class="col-12">
            <x-alert type="warning">{{ session('warning') }}</x-alert>
        </div>
    </div>
@endif

@if (session('info'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-styled-left alert-styled-custom alert-arrow-left alpha-teal border-teal alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                <span class="font-weight-semibold">{{ session('info')}}</span>
            </div>
        </div>
    </div>
@endif
