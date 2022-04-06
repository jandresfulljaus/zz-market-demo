<div class="form-group row">
	<div class="col-12">
		<div class="card">
			<input type="hidden" id="img_{{ $uniqid }}" name="{{ $name }}" class="fieldimage" value="{{ $value }}" >
			<div id="{{ $uniqid }}" class="card-img-upload mx-1 mt-1 fieldimage_button">
				<p id="msg_{{ $uniqid }}">Click para subir imagen</p>
				<img id="show_{{ $uniqid }}" class="card-img" src="{{ $value }}" alt="">
			</div>
			<div class="card-body">
				<div class="d-flex align-items-start flex-nowrap">
					<div>
						<h6 class="font-weight-semibold mr-2">{{ $label }}</h6>
						<span>{{ $value }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>