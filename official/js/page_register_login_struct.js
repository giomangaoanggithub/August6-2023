var current_hosting_url = "";

function get_hosting_url() {
  sample_url = window.location.href;
  target = "official/";
  // alert("sample_url: " + sample_url.includes("official/"));

  for (i = 0; i < sample_url.indexOf(target) + target.length; i++) {
    current_hosting_url += sample_url[i];
  }
  // alert(current_hosting_url);
}

get_hosting_url();

$("#show-login-form").click(function () {
  document.getElementById(
    "login-register-right-side-form-padding"
  ).style.display = "block";
  document.getElementById(
    "login-register-right-side-form-logintitle"
  ).style.display = "block";
  document.getElementById(
    "login-register-right-side-form-registertitle"
  ).style.display = "none";
  document.getElementById("show-confirm-password").style.display = "none";
  document.getElementsByClassName("login-register-btns")[0].style.display =
    "inline";
  document.getElementsByClassName("login-register-btns")[1].style.display =
    "none";
});

$("#show-register-form").click(function () {
  document.getElementById(
    "login-register-right-side-form-padding"
  ).style.display = "block";
  document.getElementById(
    "login-register-right-side-form-logintitle"
  ).style.display = "none";
  document.getElementById(
    "login-register-right-side-form-registertitle"
  ).style.display = "block";
  document.getElementById("show-confirm-password").style.display = "block";
  document.getElementsByClassName("login-register-btns")[0].style.display =
    "none";
  document.getElementsByClassName("login-register-btns")[1].style.display =
    "inline";
});
