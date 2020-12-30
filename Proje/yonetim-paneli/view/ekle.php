<?php
$li=mysqli_connect("localhost", "root", "","b191210029");
if (isset($_POST["baslik"]) && isset($_POST["icerik"]) && isset($_POST["kategoriId"]) && isset($_POST["postID"])){
    mysqli_query($li, "CALL `addnews`('" . $_POST["baslik"] . "', '" . $_POST["icerik"] . "', " . $_POST["kategoriId"] . ", '" . $_POST["postID"] . "')");
}
if (isset($_POST["kategoriId"]) && isset($_POST["postID"])){
    mysqli_query($li, "CALL `addCategory`(" . $_POST["kategoriId"] . ", '" . $_POST["postID"] . "')");
}
if (isset($_POST["location"]) && isset($_POST["postID"])){
    mysqli_query($li, "CALL `addlocation`(" . $_POST["location"] . ", '" . $_POST["postID"] . "')");
}
if (isset($_POST["preserve"]) && isset($_POST["postID"])){
    mysqli_query($li, "CALL `addPreserve`(" . $_POST["preserve"] . ", '" . $_POST["postID"] . "')");
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

    <h1 >HABER EKLEME</h1>

    <form method="post">
        <ul>
            <li>
                <label for="postID">PostID: </label>
                <input type="text" name="postID">
            </li>
            <li>
                <label for="baslik">Başlık: </label>
                <input type="text" name="baslik">
            </li>
            <li>
                <label for="icerik">İçerik: </label>
                <input type="text" name="icerik">
            </li>
            <li>
                <label for="kategoriId">KategoriId: </label>
                <input type="text" name="kategoriId">
            </li>
            <li>
                <label for="location">Lokasyon: </label>
                <input type="text" name="location">
            </li>
            <li>
                <label for="preserve">Preserve: </label>
                <input type="text" name="preserve">
            </li>
            <li>
                <button type="submit">Haber Ekle</button>
            </li>
        </ul>
    </form>
</div>
</body>
</html>