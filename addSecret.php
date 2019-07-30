<?php
if (isset($_POST['textarea']) && isset($_POST['password'])){

    // Переменные с формы
    $textarea = $_POST['textarea'];
    $password = $_POST['password'];

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

    // Генерация ссылки
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $url = substr(str_shuffle($permitted_chars), 0, 6);

    // Добавление в БД
    $result = $mysqli->query("INSERT INTO ".$db_table." (textarea,password,url) VALUES ('$textarea','$password','$url')");

    // Взятие из БД textarea
    $textareaFromBDMysql = $mysqli->query("SELECT textarea FROM ".$db_table." WHERE url= '".$url."' LIMIT 1");
    $row = $textareaFromBDMysql->fetch_assoc();
    $textareaFromBD=$row['textarea'];

    if ($result == true){
        echo "<h2>Ссылка на секретный контент:  </h2>"."<a href='http://whyhs.ru/$url'>http://whyhs.ru/$url</a>";
    }else{
        echo "Информация не занесена в базу данных";
    }

    // Создание файла по ссылке
    $filename = "$url";
    if (!file_exists($filename)) {
        touch($filename);
        chmod($filename,0666);// Устанавливаем CHMOD на страницу
    }
    $string = "
    <html>
    <head>
        <meta charset=\"utf-8\">
    </head>
    <body>
        <style type=\"text/css\">
        html {
            padding: 0;
            margin: 0;
        }
        .modalDialog {
         position: fixed;
         font-family: Arial, Helvetica, sans-serif;
         top: 0;
         right: 0;
         bottom: 0;
         left: 0;
         background: #000;
         z-index: 99999;
         display: block;
        }
        .modalDialog > div {
         width: 400px;
         position: relative;
         margin: 10% auto;
         padding: 5px 20px 13px 20px;
         border-radius: 10px;
         background: #fff;
         background: -moz-linear-gradient(#fff, #999);
         background: -webkit-linear-gradient(#fff, #999);
         background: -o-linear-gradient(#fff, #999);
        }
        .close {
            display: none;
        }
        .button {
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
        .button:hover { opacity: 0.7; }
        .button:active { opacity: 0.5; }
        input {
            color: black;
        }
        </style>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
        <script type=\"text/javascript\">
        function AddPassword () {
            var inputPassword = document.getElementById(\"my_pass\").value;
            if (inputPassword == \"$password\") {
            var win = document.getElementById(\"openModal\");
            win.classList.add(\"close\");
            
            var findSecretContent = document.getElementById(\"secretContent\");
            var h1 = document.createElement('h1');
            h1.innerHTML = \"Секретный контент:\";
            findSecretContent.appendChild(h1);
            var input = document.createElement('input');
            input.innerHTML = \"$url\";
            input.setAttribute(\"name\", 'url');
            input.setAttribute(\"value\", \"$url\");
            input.setAttribute(\"hidden\", 'true');
            findSecretContent.appendChild(input);
            var p = document.createElement('p');
            p.innerHTML = \"$textareaFromBD\";
            findSecretContent.appendChild(p);
            }
        }
        </script>
        <div id=\"openModal\" class=\"modalDialog\">
            <div align=\"center\">
                <h2>Введите пароль</h2>
                <input type=\"password\" id=\"my_pass\" placeholder=\"Введите пароль\"><br>
                <input class=\"button\" type=\"submit\" onclick=\"AddPassword();\" value=\"Войти\">
            </div>
        </div>
        <form action='delete.php' method='POST'>
            <div id='secretContent' style=\"color: #000;\">
            </div>
            <button class='button'>Удалить секретный контент</button>
        </form>
    </body> 
    </html>";
    $file = fopen("$filename","w");
    fputs($file,$string);
    fclose($file);

}
?>