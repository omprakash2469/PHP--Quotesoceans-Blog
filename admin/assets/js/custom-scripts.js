// ----------- Toggle Modal  ----------------//
let modal = document.getElementById("modal");
function modalOpen() {
    if (modal.style.display == "") {
        modal.classList.add('d-flex');
        // modal.style.display = "block";
        modal.style.opacity = "1";
    } else {
        modal.style.display = "none";
        modal.style.opacity = "0";
    }
}