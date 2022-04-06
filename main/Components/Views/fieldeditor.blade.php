<div class="form-group">
    <label class="{{ $classlabel }} text-primary font-weight-bold text-uppercase">{{ $label }}</label>
    <div class="{{ $classinput }}">
        <textarea id="summernote" class="form-control" name="{{ $name }}">{{ $value }}</textarea>
    </div>   
</div>

<!-- Oculto el botón de subir imagen ya que la imagen se guardaría en la base de datos y no es conveniente -->
<style type="text/css">
	.note-group-select-from-files {
  display: none;
}
</style>