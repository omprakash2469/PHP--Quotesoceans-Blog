// ----------- Authors editing  ---------------- //
let table = document.querySelectorAll('#authors-table tr'); // get the rows of table

for (let i = 1; i < table.length; i++) {
    num = table[i].querySelector("#actions").querySelector("#edit"); // Select the button you want to click to trigger event
    num.addEventListener('click', function (item) {

        // Form Variables
        let pagetitle = "Update Author";
        let id = item.path[3].children[0].innerHTML;
        let name = item.path[3].children[1].innerHTML;
        let profession = item.path[3].children[2].innerHTML.toLowerCase().trim();
        let action = "?editform";
        let button = "Update";

        if (id != 0) {
            // console.log(modaltitle);
            let modaltitle = document.getElementById('addAuthorLabel').innerText = pagetitle;
            // console.log(modalid);
            let modalid = document.getElementById('hiddenid').value = id;
            // console.log(modalname);
            let modalname = document.getElementById('name').value = name;
            // console.log(modalprofession);
            // continue from here
            let modalprofession = document.querySelectorAll('#profession input[type="checkbox"]');
            for (i = 0; i < modalprofession.length; i++) {
                if (modalprofession[i].innerText.trim() == profession) {
                    console.log("condition is true");
                }
                else {
                    console.log("condition is false");
                }
            }
            // console.log(modalaction);
            let modalaction = document.getElementById('addform').action = action;
            // console.log(modalbutton);
            let modalbutton = document.getElementById('addbtn').innerText = button;
            modalOpen();
        }
    });
}

// ----------- Authors deleting  ----------------//
for (let i = 1; i < table.length; i++) {
    num = table[i].querySelector("#actions").querySelector("#delete"); // Select the button you want to click to trigger event
    num.addEventListener('click', function (item) {

        // Form Variables
        let pagetitle = "Are you sure you want to delete?";
        let id = item.path[3].children[0].innerHTML;
        let name = item.path[3].children[1].innerHTML;
        let action = "";
        let button = "Delete";

        if (id != 0) {
            let modaltitle = document.getElementById('addAuthorLabel').innerText = pagetitle;
            // console.log(modaltitle);
            let modalid = document.getElementById('hiddenid').value = id;
            // console.log(modalid);
            let modalname = document.getElementById('name').value = name;
            // console.log(modalname);
            let modalaction = document.getElementById('addform').action = action;
            // console.log(modalaction);
            let modalbutton = document.getElementById('addbtn').innerText = button;
            // console.log(modalbutton);
            modalOpen();
        }
    });
}

function closeModal() {
    let modaltitle = document.getElementById('addAuthorLabel').innerText = "Add New Author";
    let modalid = document.getElementById('hiddenid').value = "";
    let modalname = document.getElementById('name').value = "";
    let modalprofession = document.getElementById('profession').value = "";
    let modalaction = document.getElementById('addform').action = "?addform";
    let modalbutton = document.getElementById('addbtn').innerText = "Add Author";

    modal.classList.remove('d-flex');
    modal.style.opacity = "0";
}