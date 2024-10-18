
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
        
        let date = new Date();
        date.setTime(date.getTime() + (60 * 60 * 24 * 30 * 1000)); 
        document.cookie = "edit_entry=" + key + "; expires=" + date.toUTCString() + "; path=/";

        window.location.href = "edit_entry.php"; 
    });
}