<?php
$li=mysqli_connect("localhost", "root", "","b191210029");
if (isset($_POST["baslik"])&&empty($_POST["baslik"])){
    echo "<h1> Please entry a value!</h1>";
}
if (isset($_POST["baslik"])&&!empty($_POST["baslik"])){
    mysqli_query($li, "CALL `postSil`('" . $_POST["baslik"] . "')");
}?>

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

    <h1 >HABER SİL</h1>

    <form method="post">
        <ul>
            <li>
                <label for="baslik">Silmek İstediğiniz Haber Başlığı</label>
                <input type="text" name="baslik">
            </li>
            <li>
                <button type="submit">Haber Sil</button>
            </li>
        </ul>
    </form>
</div>
</body>
</html>