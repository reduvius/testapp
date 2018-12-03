// Validate registration form
function validateForm() {
    var name = document.forms["reg"]["name"].value;
    var email = document.forms["reg"]["email"].value;
    var password = document.forms["reg"]["password"].value;
    var password_confirm = document.forms["reg"]["password_confirm"].value;
    var val_info = document.getElementById("val-info");

    if (name == "") {
        val_info.innerHTML = "Username must be filled out.";
        return false;
    }
    if (email == "") {
        val_info.innerHTML = "Email must be filled out.";
        return false;
    }
    if (password == "") {
        val_info.innerHTML = "Password must be filled out.";
        return false;
    }
    if (password.length < 6) {
        val_info.innerHTML = "Password must be at least 6 characters long.";
        return false;
    }
    if (password_confirm == "") {
        val_info.innerHTML = "Password confirmation must be filled out.";
        return false;
    }
    if (password != password_confirm) {
        val_info.innerHTML = "Passwords do not match!";
        return false;
    }
}
