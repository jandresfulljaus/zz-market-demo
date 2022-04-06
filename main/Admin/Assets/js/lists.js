"use strict";

document.querySelectorAll(".confirmDeletion").forEach((item) => {
    item.addEventListener("submit", (event) => {
        event.preventDefault();

        swal({
            buttons: {
                cancel: "Cancelar",
                confirm: {
                    closeModal: false,
                    text: "Eliminar",
                },
            },
            dangerMode: true,
            icon: "error",
            text: "Esta acción es irreversible",
            title: "¿Eliminar registro?",
        }).then((confirmation) => {
            if (confirmation) {
                event.target.submit();
            }
        });
    });
});
