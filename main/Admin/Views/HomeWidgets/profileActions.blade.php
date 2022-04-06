<div class="row mb-3">
    <div class="col-4">
        <a href="{{ route('admin.profile.edit') }}" class="btn bg-blue-400 btn-float home-card">
            <i class="mi-account-box mi-2x"></i>
            <span>{{__('messages.editMyProfileHome')}}</span>
        </a>
    </div>
    <div class="col-4">
        <a href="{{ route('admin.activity.list') }}" class="btn bg-blue-800 btn-float home-card">
            <i class="mi-remove-from-queue mi-2x"></i>
            <span>{{__('messages.seeMyActivityHome')}}</span>
        </a>
    </div>
    <div class="col-4">
        <a href="{{ route('admin.sessions.list') }}" class="btn bg-warning btn-float home-card">
            <i class="mi-devices-other mi-2x"></i>
            <span>{{__('messages.seeActiveSessionsHome')}}</span>
        </a>
    </div-->
</div>
