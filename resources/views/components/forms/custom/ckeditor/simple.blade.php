<textarea class="form-control" name="{{ $name }}" {{ $attributes }}>{{ $value }}</textarea>

@push('scripts')
    <script src="{{ asset('js/ckeditor5/ckeditor.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('textarea[name="{{ $name }}"]'), {
                language: 'es',
                removePlugins: [
                    'Alignment',
                    'Base64UploadAdapter',
                    'BlockQuote',
                    'FontBackgroundColor',
                    'FontColor',
                    'FontFamily',
                    'FontSize',
                    'Heading',
                    'HorizontalLine',
                    'Image',
                    'ImageCaption',
                    'ImageToolbar',
                    'ImageUpload',
                    'Indent',
                    'IndentBlock',
                    'MediaEmbed',
                    'MediaEmbedToolbar',
                    'Table',
                    'TableCaption',
                    'TableCellProperties',
                    'TableProperties',
                    'TableToolbar',
                ],
                toolbar: {
                    items: [
                        'bold',
                        'italic',
                        'underline',
                        'strikethrough',
                        'removeFormat',
                        '|',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'link',
                        '|',
                        'undo',
                        'redo',
                    ]
                },
            })
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
