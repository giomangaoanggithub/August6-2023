<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Essay Speed Checker</title>
    <link rel="stylesheet" id="page-styling" href="">
    <script>
    document.getElementById("page-styling").href = '../css/page_register_login.css';
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/tw-cen-mt-condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../imgs/favicon.ico">
</head>

<body id="login_register_background" class="p-4" style="background-image: imgs/background-img-page-register-login.jpg">
    <div class="row flex-column-reverse flex-sm-row">
        <div class="login-register-left-side col-sm-6">
            <div>
                <img src="../imgs/boy-ride-rocket.webp" class="img-fluid" alt="" srcset="">
            </div>

            <div>
                <h1>• Escape essay paper work hell.<br><br>• Swiftly finish checking essays.<br><br>• Commit your hours
                    to
                    what
                    matters.</h1>
            </div>

        </div>
        <div class="login-register-right-side col-sm-6 text-center">
            <div id="login-register-right-side-title">
                Essay Speed Checker
            </div>
            <div id="login-register-right-side-btns">
                <button id="show-login-form">
                    <h2>LOGIN</h2>
                </button>
                <button id="show-register-form">
                    <h2>REGISTER</h2>
                </button>
            </div>
            <div id="login-register-right-side-form-padding">
                <div id="login-register-right-side-form">
                    <br>
                    <div id="login-register-right-side-form-logintitle">
                        <h1>LOGIN</h1>
                    </div>
                    <div id="login-register-right-side-form-registertitle">
                        <h1>REGISTER</h1>
                    </div>
                    <div id="login-register-right-side-inputs"><input type="text" placeholder="email"
                            id="email-input"><br><br><input type="password" placeholder="password"
                            id="password-input"><br><br><input id="show-confirm-password" type="password"
                            placeholder="confirm password"></div><br>
                    <div class="row">
                        <div class="col-sm-6"><select name="role" id="role">
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                            </select></div>
                        <div class="col-sm-6 p-4">
                            <button id="account-loggingin" class="login-register-btns">LOGIN</button>
                            <button id="account-registering" class="login-register-btns">REGISTER</button>
                        </div>
                    </div>

                </div>
                <br>

            </div>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<!-- <script>
var current_hosting_url = "";
sample_url = window.location.href;
target = "official/";
// alert("sample_url: " + sample_url.includes("official/"));
for (i = 0; i < sample_url.indexOf(target) + target.length; i++) {
    current_hosting_url += sample_url[i];
}
document.getElementById("page_register_login_struct").src = current_hosting_url + "js/page_register_login_struct.js";
document.getElementById("page_register_login_funct").src = current_hosting_url + "js/page_register_login_funct.js";
</script> -->
<script id="page_register_login_struct" src="../js/page_register_login_struct.js">
</script>
<script id="page_register_login_funct" src="../js/page_register_login_funct.js">
</script>


</html>