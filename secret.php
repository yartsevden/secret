<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Secret</title>
</head>
<body>
<style>
    button {
        width: 173px;
        margin-top: 30px;
        color: black;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        user-select: none;
        padding: .5em 2em;
        outline: none;
        border: 2px solid;
        border-radius: 1px;
        transition: 0.2s;
    }
    button:hover { opacity: 0.7; }
    button:active { opacity: 0.5; }
    input {
        color: black;
    }
</style>
<header>
    <h1>Добро пожаловать на сервис Secret</h1>
</header>
<h2>Введите секретный контент</h2>
<form action="addSecret.php" method="POST">
    <textarea cols="80" rows="10" name="textarea" required></textarea>
    <h2>Введите пароль</h2>
    <input type="password" maxlength="25" size="27" name="password" required><br/>
    <button id="button">Зашифровать</button>
</form>
</body>
</html>