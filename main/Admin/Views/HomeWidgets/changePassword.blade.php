<div class="col-12">
    <div class="alert bg-danger text-white alert-styled-left alert-dismissible">
        <h6 class="font-weight-semibold pb-0 mb-0">
            Es necesario cambiar su clave.
        </h6>
        Hemos detectado que sigue usando la clave por omisión por lo que es
        sumamente importante que cambie su clave de acceso desde su perfil.
        <br>
        <a
            href="{{ route('admin.profile.edit') }}"
            class="mt-2 btn btn-sm bg-red legitRipple"
        >
            cambiar clave de acceso
        </a>
    </div>
</div>
