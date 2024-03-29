<!DOCTYPE html>
<html lang="en">

<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Infinitops\Referral\Models\User;

$phoneNumber = '';
if (isset($_GET['phone_number'])) $phoneNumber = $_GET['phone_number'];
if ($phoneNumber == '')
    header('location:  forgot_password.php');
$user = User::where('phone_number', $phoneNumber)->first();
if ($user == null)
    header('location:  forgot_password.php');

?>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Forgot | Jumuia</title>


    <?php include('./header.php'); ?>
    <!-- <?php
            // if (isset($_SESSION['login_id']))
            // header("location:index.php?page=home");

            ?> -->

</head>
<style>
    body {
        width: 100%;
        height: calc(100%);
        position: fixed;
        top: 0;
        left: 0
            /*background: #007bff;*/
    }

    main#main {
        width: 100%;
        height: calc(100%);
        display: flex;
    }
</style>

<body class="bg-white">


    <main id="main">

        <div class="align-self-center w-100">
            <!-- <h4 class="text-white text-center"><b>Jumuia</b></h4> -->
            <div class="text-center mb-2">
                <img src="assets/img/logo.jpeg" alt="Jumuia" srcset="">
            </div>
            <div id="" class=" row justify-content-center">
                <div class="card col-md-4 m-2">
                    <p class="text-center">An OTP has been sent to email <?php echo $user->email; ?></p>
                    <div class="card-body">
                        <form id="formForgotPasswordReset" action="" method="POST" onsubmit="event.preventDefault()">
                            <div class="form-group">
                                <label for="inputOtp" class="control-label text-dark">OTP</label>
                                <input type="number" id="inputOtp" name="otp" class="form-control form-control-sm" required>
                            </div>

                            <div class="form-group">
                                <label for="password" class="control-label text-dark">Password</label>
                                <input type="password" id="inputPassword" name="password" class="form-control form-control-sm" required onchange="passwordChange()">
                            </div>

                            <div class="form-group">
                                <label for="inputPasswordConfirm" class="control-label text-dark">Confirm Password</label>
                                <input type="password" id="inputPasswordConfirm" name="password_confirm" class="form-control form-control-sm" required onchange="passwordChange()">
                            </div>
                            <p class="text-danger"></p>
                            <center><input class="btn-sm btn-block btn-wave col-md-4 btn-primary" id="btnSubmit" name="submit" type="submit" value="Reset Password" onchange="passwordChange()"></center>
                        </form>

                        <div class="text-center">
                            <a class="small" href="login.php">Back to login</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <style>
        .password-mismatch {
            border-top: 4px solid #ff0006 !important;
        }

        .password-mismatch:hover {}
    </style>

    <script type="text/javascript">
        const formForgotPasswordReset = document.getElementById('formForgotPasswordReset')
        const phoneNumber = '<?php echo $phoneNumber; ?>'

        const inputOtp = document.getElementById('inputOtp')
        const inputPassword = document.getElementById('inputPassword')
        const inputPasswordConfirm = document.getElementById('inputPasswordConfirm')
        const btnSubmit = document.getElementById('btnSubmit')
        formForgotPasswordReset.addEventListener('submit', e => {
            e.preventDefault();
            let otp = inputOtp.value
            let password = inputPassword.value
            let passwordConfirm = inputPasswordConfirm.value
            if(password != passwordConfirm){
                alert("Passwords do not match")
                return
            }
            fetch("../reset-password", {
                method: 'POST',
                body: JSON.stringify({
                    phone_number: phoneNumber, pin: otp, password: password
                }),
                headers: {
                    "content-type": "application/x-www-form-urlencoded"
                }
            })
            .then(response => {
                return response.json();
            })
            .then(response => {
                if(response.code == 200){
                    console.log("Password reset successfully...");
                    setTimeout(() => {
                        location.replace("login")
                    }, 978)
                 } else{
                    console.log(response)
                    throw new Error(response.message)
                 } 
            })
            .catch(error => {
                alert(error.message)
            })
        })

        const passwordChange = (e) => {
            let password = inputPassword.value
            let passwordConfirm = inputPasswordConfirm.value
            console.log("Method called");
            if (passwordConfirm != "") {
                if (password != passwordConfirm) {
                    if (!inputPasswordConfirm.classList.contains('password-mismatch')) inputPasswordConfirm.classList.add('password-mismatch')
                } else {
                    if (inputPasswordConfirm.classList.contains('password-mismatch')) inputPasswordConfirm.classList.remove('password-mismatch')
                }
            }
        }
    </script>

</body>

</html>