
let regButton = document.getElementById("reg-btn");
if (regButton !== null){
    regButton.addEventListener("click", () =>{
        window.location.href = "register.php";
    });
}

let editBtn = document.getElementById("edit-btn");
if (editBtn !== null){
    editBtn.addEventListener('click', () => {
        
        let key = editBtn.closest('.entry').querySelector('.entry-body p').innerText;
        document.cookie = "edit_entry="
        window.location.href = "edit_entry.php"; 
    })
}