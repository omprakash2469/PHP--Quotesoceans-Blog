// ----------- Category editing  ---------------- //
let table = document.querySelectorAll('#category-table tr'); // get the rows of table

for (let i = 1; i < table.length; i++) {
    num = table[i].querySelector("#actions").querySelector("#edit"); // Select the button you want to click to trigger event
    num.addEventListener('click', function (item) {

        // Form Variables
        let pagetitle = "Update Category";
        let id = item.path[3].children[0].innerHTML;
        let name = item.path[3].children[1].innerHTML;
        let upload = item.path[3].children[2].childNodes[0].href;
        let action = "?editform";
        let button = "Update";

        if (id != 0) {
            let modaltitle = document.getElementById('addCategoryLabel').innerText = pagetitle;
            // console.log(modaltitle);
            let modalid = document.getElementById('hiddenid').value = id;
            // console.log(modalid);
            let modalname = document.getElementById('name').value = name;
            // console.log(modalname);
            let modalupload = document.getElementById('imgupload').href = upload;
            document.getElementById('imgupload').innerHTML = "Uploaded Image";
            // console.log(modalupload);
            let modalaction = document.getElementById('addform').action = action;
            // console.log(modalaction);
            let modalbutton = document.getElementById('addbtn').innerText = button;
            // console.log(modalbutton);
            modalOpen();
        }
    });
}

// ----------- Category deleting  ----------------//
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
            let modaltitle = document.getElementById('addCategoryLabel').innerText = pagetitle;
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
    let modaltitle = document.getElementById('addCategoryLabel').innerText = "Add New Category";
    let modalid = document.getElementById('hiddenid').value = "";
    let modalname = document.getElementById('name').value = "";
    let modalupload = document.getElementById('imgupload').href = "";
    document.getElementById('imgupload').innerHTML = "Upload Image Here";
    let modalaction = document.getElementById('addform').action = "?addform";
    let modalbutton = document.getElementById('addbtn').innerText = "Add Category";

    modal.classList.remove('d-flex');
    modal.style.opacity = "0";
}