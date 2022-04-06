<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4 class="font-weight-semibold">
                @php
                    use Main\Auth\Models\Role;
                    if(Auth::user()->isRoot()){
                            $text = '';
                    }elseif(Auth::user()->isAdmin()){
                            $text = '';
                    }else{
                        //Si es User hago esto
                            $text = __('messages.applicantNumberHeader');
                    }   
                @endphp
                {{ $text }}
                {{ auth()->user()->organization->name }}
                ({{ strtoupper(App::getLocale()) }})
            </h4>
        </div>
        @isset($admin_info->buttons)
            <div class="header-elements">
                <div class="d-flex justify-content-center">
                    @foreach($admin_info->buttons as $button)
                        <a
                            href="{{ $button['route'] }}"
                            class="btn btn-link btn-float font-size-sm font-weight-semibold text-default"
                        >
                            <i class="{{ $button['icon'] }}  {{ isset($button['icon_class']) ? $button['icon_class'] : 'text-primary' }}"></i>
                            <span>{{ $button["title"] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endisset
    </div>
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline d-none d-md-block">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('admin.home') }}" class="breadcrumb-item">
                    <i class="icon-home2 mr-2"></i>
                    {{__('messages.homeHome')}}
                </a>
                <span class="breadcrumb-item active">{{ $admin_info->title }}</span>
            </div>
        </div>
    </div>
</div>
