<?php
require_once('session_check.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OTP Verification Form</title>
    <link rel="stylesheet" href="style.css" />
    <!-- Boxicons CSS -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <style>
        /* Import Google font - Poppins */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #4070f4;
        }

        :where(.container, form, .input-field, header) {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #fff;
            padding: 30px 65px;
            border-radius: 12px;
            row-gap: 20px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .container header {
            height: 65px;
            width: 65px;
            background: #4070f4;
            color: #fff;
            font-size: 2.5rem;
            border-radius: 50%;
        }

        .container h4 {
            font-size: 1.25rem;
            color: #333;
            font-weight: 500;
        }

        form .input-field {
            flex-direction: row;
            column-gap: 10px;
        }

        .input-field input {
            height: 45px;
            width: 42px;
            border-radius: 6px;
            outline: none;
            font-size: 1.125rem;
            text-align: center;
            border: 1px solid #ddd;
        }

        .input-field input:focus {
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }

        .input-field input::-webkit-inner-spin-button,
        .input-field input::-webkit-outer-spin-button {
            display: none;
        }

        form button {
            margin-top: 25px;
            width: 100%;
            color: #fff;
            font-size: 1rem;
            border: none;
            padding: 9px 0;
            cursor: pointer;
            border-radius: 6px;
            pointer-events: none;
            background: #6e93f7;
            transition: all 0.2s ease;
        }

        form button.active {
            background: #4070f4;
            pointer-events: auto;
        }

        form button:hover {
            background: #0e4bf1;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <i class="bx bxs-check-shield"></i>
        </header>
        <h4>Enter OTP Code</h4>
        <form action="otpscriptverify.php" method="post">
            <div class="input-field">
                <input type="number" name="otp[]" required />
                <input type="number" name="otp[]" disabled />
                <input type="number" name="otp[]" disabled />
                <input type="number" name="otp[]" disabled />
                <input type="number" name="otp[]" disabled />
                <input type="number" name="otp[]" disabled />
            </div>
            <button type="submit" name="verify" id="verifyButton">Verify OTP</button>
        </form>
        <p id="expirationMessage"></p>
    </div>
</body>

<script>
    const inputs = document.querySelectorAll("input"),
        button = document.querySelector("#verifyButton"),
        form = document.querySelector("form");

    let otpExpireTime = 60;


    inputs.forEach((input, index1) => {
        input.addEventListener("keyup", (e) => {
            const currentInput = input,
                nextInput = input.nextElementSibling,
                prevInput = input.previousElementSibling;
            if (currentInput.value.length > 1) {
                currentInput.value = "";
                return;
            }
            if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
                nextInput.removeAttribute("disabled");
                nextInput.focus();
            }

            if (e.key === "Backspace") {
                inputs.forEach((input, index2) => {
                    if (index1 <= index2 && prevInput) {
                        input.setAttribute("disabled", true);
                        input.value = "";
                        prevInput.focus();
                    }
                });
            }
            if (!inputs[3].disabled && inputs[3].value !== "") {
                button.classList.add("active");
                return;
            }
            button.classList.remove("active");
            updateExpirationMessage();
        });
    });
    window.addEventListener("load", () => {
        inputs[0].focus();
        startOtpExpirationTimer();
    });

    function startOtpExpirationTimer() {
        const timerInterval = setInterval(() => {
            otpExpireTime--;
            if (otpExpireTime <= 0) {
                clearInterval(timerInterval);
                disableInputsAndShowMessage();
            }
            updateExpirationMessage();
        }, 1000);
    }

    function disableInputsAndShowMessage() {
        inputs.forEach((input) => {
            input.setAttribute("disabled", true);
        });
        button.setAttribute("disabled", true);
        const expirationMessage = document.createElement("p");
        expirationMessage.innerText = "OTP has expired. Please generate a new OTP";
        expirationMessage.style.color = "red";
        form.appendChild(expirationMessage);
        setTimeout(() => {
            alert("Redirecting to login page. Please generate a new OTP.");
            window.location.href = "index.php";
        }, 2000);
    }

    function updateExpirationMessage() {
        const expirationMessage = document.querySelector("#expirationMessage");
        if (expirationMessage) {
            expirationMessage.innerText = `Time remaining : ${otpExpireTime} seconds`;
        }
    }
</script>

</html>