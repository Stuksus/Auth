<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>login</title>
</head>
<body>
<form method="post">
    Логин: <input name="login">
    Пароль: <input name="password">
    <input name="Enter" type="submit" value="войти">
    <input name="registration" type="submit" value="зарегестрироваться">

</form>


</body>
</html>

<?php
header("Content-Type: text/html; charset=utf-8");
$db = mysqli_connect('localhost', 'rooting', '123123', 'firstDataBase');
mysqli_set_charset($db, 'utf-8');

if (isset($_POST['Enter'])) {
    $query = "select login , pass from login WHERE login='" . $_POST['login'] . "'";

    $res = mysqli_query($db, $query);
    $array = mysqli_fetch_array($res);
    if ($_POST['login'] == $array['login'] && md5($_POST['password']) == $array['pass']) {
        header("Location:todo.php?login=" . $array['login']);
        setcookie('login', $_POST['login'], time() + 3600 * 3600, "/");
    } else {
        echo 'Вы не смогли авторизоваться!';
        echo "<meta charset='UTF-8'>
<form method='post'>
<input name='Authenticate' type='submit' value='Попробовать войти повторно или зарегестрироваться'>
</form>";
    }
} elseif (isset($_POST['registration'])) {
    $queryCount = "SELECT count(*) as count  FROM `login` where login LIKE '" . $_POST['login'] . "'";
    $result = mysqli_query($db, $queryCount);
    $count = mysqli_fetch_array($result);
    if ($count['count'] >= 1) {
        echo 'Такой логин уже существует. Введите другой логин  или войдите в уже созданную учетную запись';
        die();
    } else {
        $queryreg = "INSERT INTO `login`( `login`, `pass`) VALUES ( '" . $_POST['login'] . "','" . md5($_POST['password']) . "')";
        $res3 = mysqli_query($db, $queryreg);
        header("Location:todo.php?login=" . $_POST['login']);


        $queryAddWorkDB = "
                CREATE TABLE `" . $_POST['login'] . 'Work' . "` (
                        `user` text NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $queryInsertWorkDB = "INSERT INTO `" . $_POST['login'] . 'Work' . "` (`user`) VALUES
                        ('" . $_POST['login'] . "');";

        $queryAddDB = "
          
                CREATE TABLE `" . $_POST['login'] . "` (
                  `id` int(11) NOT NULL,
                  `description` text NOT NULL,
                  `is_done` tinyint(4) NOT NULL DEFAULT '0',
                  `date_added` datetime NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8; ";

        $queryPrimary = "  ALTER TABLE `" . $_POST['login'] . "`
                  ADD PRIMARY KEY (`id`);";


        $queryAI = "  ALTER TABLE `" . $_POST['login'] . "`
                  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;";


        mysqli_query($db, $queryAddWorkDB);
        mysqli_query($db, $queryInsertWorkDB);
        mysqli_query($db, $queryAddDB);
        mysqli_query($db, $queryPrimary);
        mysqli_query($db, $queryAI);
    }
    setcookie('login', $_POST['login'], time() + 3600 * 3600, "/");

}




