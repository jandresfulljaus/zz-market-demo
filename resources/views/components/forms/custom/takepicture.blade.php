<button type="button" class="btn btn-primary mb-2" onclick="TakePicture.showForm('{{ $fileInputId }}')">{{ $button }} <i class="icon-play3 ml-2"></i></button>

<div id="modal_take_picture" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="text-center">
                                <video id="webcam_picture" autoplay playsinline width="640" style="display: inline-block; max-width:100%;"></video>
                            </div>
                            <canvas id="canvas_picture" class="d-none"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" onclick="TakePicture.closeForm();">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="TakePicture.snap();">Capturar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
<script src="{{ asset('js/takepicture.js') }}" charset="utf-8"></script>

<script type="text/javascript">
    TakePicture.init('webcam_picture', 'canvas_picture');
</script>
@endpush
