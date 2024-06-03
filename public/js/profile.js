document.addEventListener("DOMContentLoaded", function () {
    const btnEdit = document.getElementById("btnEdit");
    const btnCancel = document.getElementById("btnCancel");
    const contentEdit = document.getElementById("contentEdit");
    const contentProfile = document.getElementById("contentProfile");

    btnEdit.addEventListener("click", function () {
        contentProfile.style.display = "none";
        contentEdit.style.display = "block";
    });

    btnCancel.addEventListener("click", function () {
        contentProfile.style.display = "block";
        contentEdit.style.display = "none";
    });
});
