"use strict";
window.addEventListener("DOMContentLoaded", () => {

    /* Checking and Displayng the Password Strength */



    var passwd = document.getElementById("pass_word");
    var message = document.getElementById("strMessage");
    var strength = document.getElementById("strength");

    passwd.addEventListener('input', () => {
        if (passwd.value.length > 0) {
            message.style.display = "block";
        }
        else {
            message.style.display = "none";
        }
        if (passwd.value.length < 4) {
            strength.innerHTML = "WEAK";
            message.style.color = "#ff0000";
            passwd.style.borderColor = "#ff0000";

        }
        else if (passwd.value.length >= 4 && passwd.value.length < 8) {
            strength.innerHTML = "MEDIUM";
            message.style.color = "#FFC367";
            passwd.style.borderColor = "#FFC367";


        }
        else if (passwd.value.length >= 8) {
            strength.innerHTML = "STRONG";
            message.style.color = "#006600";
            passwd.style.borderColor = "#006600";

        }
    })


    // Checking for the username in the Database
    const username = document.getElementById("user_name");
    const userError = username.nextElementSibling;

    username.addEventListener("change", () => {

        const qtySpan = document.getElementById('qty');
        if (qtySpan) {
            qtySpan.remove();
        }

        // Making an AJAX request to check_username.php using the username as a parameter to check if the username exists in the database 
        const xhr = new XMLHttpRequest();

        xhr.open("GET", `check_username.php?username=<?php echo ${username.value}?>`);
        xhr.addEventListener("load", () => {
            if (xhr.status === 200) {
                if (xhr.responseText === "true") {
                    const errorMessage = document.createElement("span");
                    errorMessage.id = "qty";

                    errorMessage.style.color = "red";
                    errorMessage.textContent = "Username already exists, Please enter a different username";
                    username.insertAdjacentElement("afterend", errorMessage);

                } else if (xhr.responseText === "false") {
                }
                else {
                    const successMessage = document.createElement("span");
                    successMessage.id = "qty";

                    successMessage.style.color = "green";
                    successMessage.textContent = "Username is Available";
                    username.insertAdjacentElement("afterend", successMessage);
                }
            }
            else {
                const errorMessage = document.createElement("span");
                errorMessage.id = "qty";

                errorMessage.style.color = "red";
                errorMessage.textContent = "Please enter a Username";
                username.insertAdjacentElement("afterend", errorMessage);
            }
        });
        xhr.send();
    });


    // Getting the form elements, buttons and Error Messages
    const form = document.getElementById('register_form');
    const usernameField = document.getElementById('user_name');
    const name = document.getElementById('first_name');
    const email = document.getElementById('e_mail');
    const password = document.getElementById('pass_word');
    const verifypassword = document.getElementById('verify_password');


    const submitBtn = document.getElementById('submit');
    const resetBtn = document.getElementById('reset');


    const errorMessages = document.getElementsByClassName('error');

    // function to show the error message for a specific input element
    function showError(element) {
        element.parentNode.querySelector('.error').style.display = 'block';
    }
    // Reset all error messages to their initial value
    function resetErrors() {
        for (let i = 0; i < errorMessages.length; i++) {
            errorMessages[i].style.display = 'none';
        }
    }



    // Listen for the form submit event
    form.addEventListener('submit', function (e) {
        let hasError = false;
        resetErrors();

        // Validating the username for errors
        if (usernameField.value.length < 3 || !/^[a-zA-Z0-9]+$/.test(username.value)) {
            showError(username);
            hasError = true;
        }

        // Validating the name for errors
        if (name.value.trim() === '' || !/^[a-zA-Z\s]+$/.test(name.value.trim())) {
            showError(name);
            hasError = true;
        }

        // Validating the email for errors 
        if (email.value.trim() === '' || !/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(email.value.trim())) {
            showError(email);
            hasError = true;
        }

        // Validating the password FOR ERRORS
        if (password.value.length < 8) {
            showError(password);
            hasError = true;
        }

        // Validating the check password to check if they are the same
        if (password.value !== verifypassword.value) {
            showError(verifypassword);
            hasError = true;
        }

        // If any errors occurred, prevent the form from submitting
        if (hasError) {
            e.preventDefault();
        }
    });

    // Listen for the reset button click event
    resetBtn.addEventListener('click', function () {
        resetErrors();
    });


});