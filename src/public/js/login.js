// Validate login form
function validateForm() {
    var email = document.forms["login"]["email"].value;
    var password = document.forms["login"]["password"].value;
    var val_info = document.getElementById("val-info");

    if (email == "") {
        val_info.innerHTML = "Email must be filled out.";
        return false;
    }
    if (password == "") {
        val_info.innerHTML = "Password must be filled out.";
        return false;
    }
}
