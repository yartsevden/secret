<?php
if (isset($_POST['url'])) {
    // Переменные с формы
    $url = $_POST['url'];
    // Параметры для подключения
    $db_host = "localhost";
    $db_user = "u0648598_secret";
    $db_password = "u0648598_secret";
    $db_base = 'u0648598_secret';
    $db_table = "secret";

    // Подключение к базе данных
    $mysqli = new mysqli($db_host,$db_user,$db_password,$db_base);

    // Если есть ошибка соединения, выводим её и убиваем подключение
    if ($mysqli->connect_error) {
        die('Ошибка : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    }

    // Удаление в БД
    $result = $mysqli->query("DELETE FROM ".$db_table." WHERE url= '".$url."' LIMIT 1");

    if ($result == true){
            echo "<h1>Секретный контент удален<h1><h2>Перейти в начало <a href='http://whyhs.ru/secret.php'>http://whyhs.ru/secret.php</a></h2>";
        }else{
            echo "Информация не занесена в базу данных";
        }

}
?>