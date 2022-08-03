<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>

    <link rel="stylesheet" href="/styles.css">
</head>

<body>
    <!-- <header>
        <h1>Шапка</h1>
    </header> -->

    <main>
        <form id="registerform" method="post">
            <div class="form-item">
                <h1 class="form-header">Регистрация</h1>
            </div>
            <div class="form-item">
                <label>Имя<span style="color: red;">*</span></label>
                <input type="text" name="name" id="name">
            </div>
            <div class="hidden-message hidden-message-name"></div>

            <div class="form-item">
                <label>Фамилия<span style="color: red;">*</span>
                </label><input type="text" name="sername" id="sername">
            </div>
            <div class="hidden-message hidden-message-sername"></div>

            <div class="form-item">
                <label>E-mail<span style="color: red;">*</span></label>
                <input type="text" name="email" id="email">
            </div>
            <div class="hidden-message hidden-message-email"></div>

            <div class="form-item">
                <label>Пароль<span style="color: red;">*</span></label>
                <input type="password" name="password" id="password">
            </div>
            <div class="hidden-message hidden-message-pass"></div>

            <div class="form-item">
                <label>Повторите пароль</label>
                <input type="password" name="password-repeat" id="password-repeat">
            </div>
            <div class="hidden-message hidden-message-pass-repeat"></div>

            <div class="form-item button-item"><input type="submit" class="submit" value="Зарегистрироваться"></div>
            <div class="register-message"></div>
        </form>
    </main>
    <footer>
        <div class="footer-container">
            <div class="footer-info first-footer-info"><a href="/">Юридическая информация</a></div>
            <div class="devider"></div>
            <div class="footer-info second-footer-info"><a href="/">Обработка персональных данных</a></div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="/script.js"></script>
</body>

</html>