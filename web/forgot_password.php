<!DOCTYPE html>
<html lang="en">

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
                    <div class="card-body">
                        <form id="formForgotPassword" action="" method="POST" onsubmit="event.preventDefault()">
                            <div class="form-group">
                                <label for="phone_number" class="control-label text-dark">Phone number</label>
                                <input type="number" id="inputPhoneNumber" name="phone_number" class="form-control form-control-sm" value="<?php echo $phone_number ?? '' ?>" required>
                            </div>
                            <p class="text-danger"></p>
                            <center><input class="btn-sm btn-block btn-wave col-md-4 btn-primary" name="submit" type="submit" value="Get OTP"></center>
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

    <script type="text/javascript">
        const formForgotPassword = document.getElementById('formForgotPassword')
        const inputPhoneNumber = document.getElementById('inputPhoneNumber')
        formForgotPassword.addEventListener('submit', e => {
            e.preventDefault();
            let phoneNumber = inputPhoneNumber.value.trim()
            if (phoneNumber.length < 10) {
                toastr.error('Your phone number is invalid')
                return
            }
            fetch('../request-otp', {
                    method: 'POST',
                    body: JSON.stringify({
                        phone_number: phoneNumber
                    }),
                    headers: {
                        "content-type": "application/x-www-form-urlencoded"
                    }
                })
                .then(response => {
                    return response.json()
                })
                .then(response => {
                    if (response.code == 200) {
                        setTimeout(() => {
                            location.replace(`forgot_password_reset?phone_number=${phoneNumber}`)
                        })
                    } else throw new Exception(response.message)
                }).catch(err => {
                    alert(err.message);
                })
        })
    </script>

</body>

</html>