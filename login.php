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
        setcookie('login',$_POST['login'],time()+3600*3600,"/");
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

    }
    setcookie('login',$_POST['login'],time()+3600*3600,"/");

}




