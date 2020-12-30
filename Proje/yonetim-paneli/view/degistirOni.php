<?php
$li=mysqli_connect("localhost", "root", "","b191210029");
if (isset($_POST["id"])&&empty($_POST["id"])&&isset($_POST["kategoriName"])&&empty($_POST["kategoriName"])){
    echo "<h1> Please entry a value!</h1>";
}
if (isset($_POST["id"])&&!empty($_POST["id"])&&isset($_POST["kategoriName"])&&!empty($_POST["kategoriName"])){
    mysqli_query($li, "CALL `addnews`(" . $_POST["id"] . ", '" . $_POST["kategoriName"] . "')");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="login-screen">

    <h1 >KATEGORİ DEĞİŞ</h1>

    <form method="post">
        <ul>
            <li>
                <label for="id">Değiştirmek İstediğiniz Haberin ID'si: </label>
                <input type="text" name="id">
            </li>
            <li>
                <label for="kategoriName">Değiştirmeyi İstediğiniz Kategori: </label>
                <input type="text" name="kategoriName">
            </li>
            <li>
                <button type="submit">Değiş</button>
            </li>
        </ul>
    </form>
</div>
</body>
</html>
