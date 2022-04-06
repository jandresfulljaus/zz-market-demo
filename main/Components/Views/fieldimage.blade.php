<div class="form-group row">
	<div class="col-12">
		<div class="card">
			<input type="file" id="{{ $uniqid }}" class="fieldimage">
			<textarea style="display:none;" id="real_{{ $uniqid }}" name="{{ $name }}">{{ $value }}</textarea>
			<div id="card_{{ $uniqid }}" class="card-img-upload mx-1 mt-1 fieldimage_button">
				@if(empty($value))
					<p id="msg_{{ $uniqid }}">Click para subir imagen</p>
					<img id="show_{{ $uniqid }}" class="card-img" style="display: none;" src="{{ $value }}" alt="">
				@else
					<p id="msg_{{ $uniqid }}" style="display: none;">Click para subir imagen</p>
					<img id="show_{{ $uniqid }}" class="card-img" src="{{ config('fulljauscms.url_web').$value }}" alt="">
				@endif
			</div>
			<div class="card-body">
				<div class="d-flex align-items-start flex-nowrap">
					<div>
						<h6 class="font-weight-semibold mr-2">{{ $label }}
							@if(!empty($value))
								<span class="text-right"><i data-id="{{ $uniqid }}" class="mi-delete fieldimage_delete"></i></span>
							@endif
						</h6>
						<span id="info_{{ $uniqid }}">{{ $value }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>
    @isset($cropOptions)
	<div class="d-none" id="cropOptions_{{ $uniqid }}">
		{{ $cropOptions }}
	</div>
    @endisset
</div>
<div class="modal fade cropImagePop" id="modal_{{ $uniqid }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">
			</div>
			<div class="modal-body">
				<div id="upload-demo" class="center-block">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-id="{{ $uniqid }}" class="btn btn-default cropCloseBtn" data-dismiss="modal">Cerrar</button>
				<button type="button" id="cropImage" class="btn btn-primary cropImageBtn">Recortar</button>
			</div>
		</div>
	</div>
</div>
