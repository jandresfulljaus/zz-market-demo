const totalCheckboxes = document.querySelectorAll(
    "input[name=notification]"
).length;
const readSelectedForm = document.querySelector("#read-selected");
const unreadSelectedForm = document.querySelector("#unread-selected");

document.querySelector("#toggle-all").addEventListener("click", (e) => {
    document.querySelectorAll("input[name=notification]").forEach((item) => {
        item.checked = e.target.checked;

        readSelectedForm.lastElementChild.disabled = !e.target.checked;
        unreadSelectedForm.lastElementChild.disabled = !e.target.checked;
        deleteSelectedForm.lastElementChild.disabled = !e.target.checked;
    });
});

document.querySelectorAll("input[name=notification]").forEach((item) => {
    item.addEventListener("click", (e) => {
        const totalCheckedCheckboxes = document.querySelectorAll(
            "input[name=notification]:checked"
        ).length;

        readSelectedForm.lastElementChild.disabled = !totalCheckedCheckboxes;
        unreadSelectedForm.lastElementChild.disabled = !totalCheckedCheckboxes;
        deleteSelectedForm.lastElementChild.disabled = !e.target.checked;

        document.querySelector("#toggle-all").checked =
            totalCheckboxes === totalCheckedCheckboxes;
    });
});

readSelectedForm.addEventListener("submit", (e) => {
    e.preventDefault();

    let fragment = document.createDocumentFragment();

    document
        .querySelectorAll("input[name=notification]:checked")
        .forEach((item) => {
            option = new Option("notification", item.value, false, true);

            fragment.appendChild(option);
        });

    e.target.querySelector("select").appendChild(fragment);

    e.target.submit();
});

unreadSelectedForm.addEventListener("submit", (e) => {
    e.preventDefault();

    let fragment = document.createDocumentFragment();

    document
        .querySelectorAll("input[name=notification]:checked")
        .forEach((item) => {
            option = new Option("notification", item.value, false, true);

            fragment.appendChild(option);
        });

    e.target.querySelector("select").appendChild(fragment);

    e.target.submit();
});
