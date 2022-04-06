<div id="loginas-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.loginWithAnotherUserChangeUser') }}</h5>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form
                action="{{ route('auth.loginas') }}"
                method="POST"
            >
                @csrf
                <div class="modal-body">
                    <x-alert type="warning">
                        {{ __('messages.warningFirstMessageChangeUser') }}
                        <br>
                        {{ __('messages.warningSecondMessageChangeUser') }}
                    </x-alert>
                    <div class="form-group">
                        <x-forms.label>{{ __('messages.selectUserChangeUser') }}</x-forms.label>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.cancelButtonChangeUser') }}</button>
                    <button type="submit" class="btn btn-info">
                        {{ __('messages.changeUserButton') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
