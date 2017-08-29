<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Панель загрузки заданий</title>
</head>
<body>
<form action="todo.php">
    <input type="submit" value="Вернуться к списку задач">
</form>
<h1>Форма выдачи задач пользователям</h1>
<form method="post">
    Задача: <input name="task">
    Пользователь: <input name="user">
    <input type="submit" name="send">
</form>
<table border="1">
    <tr>
        <td>
            Пользователи
        </td>
    </tr>
    <?php
    header("Content-Type: text/html; charset=utf-8");
    $db = mysqli_connect("localhost", "rooting", "123123", "firstDataBase");
    mysqli_set_charset($db, 'utf-8');
    $query = 'select login from login';
    $res = mysqli_query($db, $query);
    while ($data = mysqli_fetch_array($res)) {
        echo
        "<tr><td>", $data['login'],
        "</td></tr>";
    }

    if (isset($_POST['send'])) {
        mysqli_set_charset($db, 'utf-8');
        $queryNewTask = "INSERT INTO `workTasks`( `task`, `is_done`,`data`, `who`, `userP`) VALUES ('" . $_POST['task'] . "',0,'" . date('Y.m.d G.i.s') . "','" . $_COOKIE['login'] . "','" . $_POST['user'] . "')";
        mysqli_query($db, $queryNewTask);
        echo 'задача отправлена';

    }
    ?>
</table>
</body>
</html>

