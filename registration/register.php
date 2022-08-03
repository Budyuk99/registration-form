<?php

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$register_message = '';

$nameErr = $sernameErr = $emailErr = $passErr = $passErr_main = "";
$name = $sername = $email = $pass = $pass_repeat = "";
$error_messages = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Имя обязательно";
        $error_messages['success'] = 0;
        $error_messages['nameErr'] = $nameErr;
    } else {
        $name = test_input($_POST["name"]);
        $error_messages['success'] = 0;
        $error_messages['name'] = $name;

        if (!preg_match("/^[a-zA-Z ]*$/", $name) && !preg_match('/^([а-яА-ЯЁёa-zA]+)$/u', $name)) {
            $nameErr = "Допускаются только буквы и пробелы";
            $error_messages['success'] = 0;
            $error_messages['nameErr'] = $nameErr;
        }
    }

    if (empty($_POST["sername"])) {
        $sernameErr = "Фамилия обязательно";
        $error_messages['success'] = 0;
        $error_messages['sernameErr'] = $sernameErr;
    } else {
        $sername = test_input($_POST["sername"]);
        $error_messages['success'] = 0;
        $error_messages['sername'] = $sername;

        if (!preg_match("/^[a-zA-Z ]*$/", $sername) && !preg_match('/^([а-яА-ЯЁёa-zA]+)$/u', $sername)) {
            $sernameErr = "Допускаются только буквы и пробелы";
            $error_messages['success'] = 0;
            $error_messages['sernameErr'] = $sernameErr;
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "E-mail обязательно";
        $error_messages['success'] = 0;
        $error_messages['emailErr'] = $emailErr;
    } else {
        $email = test_input($_POST["email"]);
        $error_messages['success'] = 0;
        $error_messages['email'] = $email;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Неверный формат электронной почты";
            $error_messages['success'] = 0;
            $error_messages['emailErr'] = $emailErr;
        }
    }

    $pass = $_POST['password'];
    $pass_repeat = $_POST['password-repeat'];

    if (!empty($_POST['password'])) {
        if (strlen($pass) < 8) {
            $passErr_main = "Пароль слишком короткий";
            $error_messages['success'] = 0;
            $error_messages['passErr_main'] = $passErr_main;
        }

        if (!preg_match("#[0-9]+#", $pass)) {
            $passErr_main = "Пароль должен содержать хотя бы одну цифру";
            $error_messages['success'] = 0;
            $error_messages['passErr_main'] = $passErr_main;
        }

        if (!preg_match("#[a-zA-Z]+#", $pass)) {
            $passErr_main = "Пароль должен содержать хотя бы одну букву";
            $error_messages['success'] = 0;
            $error_messages['passErr_main'] = $passErr_main;
        }

        if (!preg_match("/[^a-яё]/iu", $pass)) {
            $passErr_main = "Пароль не должен содержать кириллицу";
            $error_messages['success'] = 0;
            $error_messages['passErr_main'] = $passErr_main;
        }
    }

    if (!empty($_POST['password']) and !empty($_POST['password-repeat'])) {

        if ($pass == $pass_repeat) {

            if ($nameErr === '' && $sernameErr === '' && $emailErr === '' && $passErr === '' && $passErr_main === '') {

                //db connection
                try {
                    $name = $_POST["name"];
                    $sername = $_POST["sername"];
                    $email = $_POST["email"];
                    $password = md5($_POST["password"]);

                    $connection = new PDO("mysql:host=localhost;dbname=winfox_db", "mysql", "");

                    // $check = "SELECT `ID`, `NAME`, `SERNAME`, `EMAIL` FROM users WHERE `NAME` = '$name'";
                    // $affectedRowsNumber = $connection->exec($check);

                    $sth = $connection->prepare("SELECT * FROM `users` WHERE `email` = ?");
                    $sth->execute(array($email));
                    $if_name_exsist = $sth->fetch(PDO::FETCH_ASSOC);
                    if ($if_name_exsist) {
                        $emailErr = 'Такая почта уже зарегистрирована';
                        $error_messages['success'] = 0;
                        $error_messages['emailErr'] = $emailErr;
                        $connection = null;
                    } else {
                        $sql = "INSERT INTO users (NAME, SERNAME, EMAIL, PASSWORD) VALUES ('$name', '$sername', '$email', '$password')";
                        $affectedRowsNumber = $connection->exec($sql);
                        // if we have success
                        if ($affectedRowsNumber > 0) {
                            sleep(1);
                            $register_message = 'Вы успешно зарегистрированы!';
                            $error_messages['success'] = 1;
                            $error_messages['register_message'] = $register_message;
                            $connection = null;
                        }
                    }
                } catch (PDOException $e) {
                    echo "Database error: " . $e->getMessage();
                }
            }
        } else {
            $passErr = 'Пароли не совпадают!';
            $error_messages['success'] = 0;
            $error_messages['passErr'] = $passErr;
        }
    } else if (empty($_POST['password'])) {
        $passErr_main = 'Введите пароль';
        $error_messages['success'] = 0;
        $error_messages['passErr_main'] = $passErr_main;
    } else if (!empty($_POST['password']) && empty($_POST['password-repeat'])) {
        $passErr = 'Введите пароль повторно';
        $error_messages['success'] = 0;
        $error_messages['passErr'] = $passErr;
    }
    echo json_encode($error_messages);
}


