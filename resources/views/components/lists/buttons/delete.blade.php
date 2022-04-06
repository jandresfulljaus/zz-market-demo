<form
    class="d-inline confirmDeletion"
    action="{{ $url }}"
    method="POST"
>
    @csrf
    @method('DELETE')
    <button
        class="p-1 m-1 font-size-sm font-weight-semibold btn btn-link btn-float btn-danger"
        type="submit"
    >
        <i class="mi-delete text-white"></i>
    </button>
</form>
