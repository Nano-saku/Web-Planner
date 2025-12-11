const password = document.getElementById("password");
const conf = document.getElementById("confirmPassword");
const form = document.getElementById("form");

function validate() {
  if (conf.value == "") return true;

  if (password.value !== conf.value) {
    conf.style.borderColor = "#fb0000ff";
    return false;
  } else {
    conf.style.borederColor = "#f4f4f4ff";
    return true;
  }
}

conf.addEventListener("input", validate);
password.addEventListener("input", validate);

form.addEventListener("submit", function (e) {
  if (validate()) {
    e.preventDefault();
    alert("Password do Not Match");
  }
});
