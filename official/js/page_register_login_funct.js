// this button click logs the user into its respective account

$("#account-loggingin").click(function () {
  var email = document.getElementById("email-input").value;
  var password = document.getElementById("password-input").value;
  var role = document.getElementById("role").value;

  // alert(email + "\n" + password + "\n" + role);
  // window.location =
  //   "https://37a5-112-204-168-121.ngrok-free.app/a_product/official/pages/page_teacher.php";

  if (email == "" || password == "") {
    return;
  }

  $.post(
    current_hosting_url + "php/js-request/check_account_existence.php",
    {
      email: email,
    },
    function (data) {
      if (data == "none") {
        alert("Sorry, this email does not exist");
        return;
      }
      $.post(
        current_hosting_url + "php/js-request/login_account.php",
        { email: email, password: password, role: role },
        function (data) {
          if (data == "exist") {
            if (role == "teacher") {
              window.location = current_hosting_url + "pages/page_teacher.php";
            } else {
              window.location = current_hosting_url + "pages/page_student.php";
            }
          } else {
            alert(
              "Sorry, it seems your password is incorrect for this account. Please try again..."
            );
          }
        }
      );
    }
  );
});

// this button click registers the new user and redirects them into their respective page

$("#account-registering").click(function () {
  var email = document.getElementById("email-input").value;
  var password = document.getElementById("password-input").value;
  var cpassword = document.getElementById("show-confirm-password").value;
  var role = document.getElementById("role").value;
  // alert(email + "\n" + password + "\n" + cpassword + "\n" + role);

  if (password != cpassword) {
    alert("Password does not match with confirm password...");
    return;
  }

  if (email == "" || password == "") {
    return;
  }

  $.post(
    current_hosting_url + "php/js-request/check_account_existence.php",
    {
      email: email,
    },
    function (data) {
      if (data == "exist") {
        alert("Sorry, this email is already used in this website");
      } else {
        $.post(
          current_hosting_url + "php/js-request/insert_account.php",
          {
            email: email,
            password: password,
            role: role,
          },
          function (data) {
            alert(data);
            if (role == "teacher") {
              window.location = current_hosting_url + "pages/page_teacher.php";
            } else {
              window.location = current_hosting_url + "pages/page_student.php";
            }
          }
        );
      }
    }
  );
});
