function beforeSend() {
    document.querySelector(".register-message").innerHTML = "Ожидание данных...";
}

$(document).ready(function() {
    $('#registerform').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'register.php',
            data: $(this).serialize(),
            beforeSend: beforeSend,
            success: function(response) {
                let jsonData = JSON.parse(response);

                if (jsonData.nameErr) {
                    document.querySelector(".hidden-message-name").innerHTML = jsonData.nameErr;
                } else {
                    document.querySelector(".hidden-message-name").innerHTML = "";
                }

                if (jsonData.sernameErr) {
                    document.querySelector(".hidden-message-sername").innerHTML = jsonData.sernameErr;
                } else {
                    document.querySelector(".hidden-message-sername").innerHTML = "";
                }

                if (jsonData.emailErr) {
                    document.querySelector(".hidden-message-email").innerHTML = jsonData.emailErr;
                } else {
                    document.querySelector(".hidden-message-email").innerHTML = "";
                }

                if (jsonData.passErr_main) {
                    document.querySelector(".hidden-message-pass").innerHTML = jsonData.passErr_main;
                } else {
                    document.querySelector(".hidden-message-pass").innerHTML = "";
                }

                if (jsonData.passErr) {
                    document.querySelector(".hidden-message-pass-repeat").innerHTML = jsonData.passErr;
                } else {
                    document.querySelector(".hidden-message-pass-repeat").innerHTML = "";
                }

                if (jsonData.register_message) {
                    document.querySelector(".register-message").innerHTML = jsonData.register_message;
                    document.querySelector("#password").value = "";
                    document.querySelector("#password-repeat").value = "";
                } else {
                    document.querySelector(".register-message").innerHTML = "";
                }
            }
        });
    });
});