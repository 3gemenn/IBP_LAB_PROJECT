<html>
<head>
    <title>Php Database İşlemleri</title>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $db = new PDO("mysql:host=$servername;dbname=i̇bp_lab_project", $username, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Bağlantı Başarılı";
} catch(PDOException $e) {
    echo "Bağlantı Hatası <br>: " . $e->getMessage();
}
?>
<form action="?islem=ekle" method="post">

    Name: <input type="text" name="full_name" required> <br>
    E-mail: <input type="email" name="email"><br>
    Cinsiyet:     <input type="radio" value="Erkek" name="gender" required> Erkek
                  <input type="radio" value="Kadın" name="gender" required> Kadın
    <br>

    <input type="submit" value="Gönder" name="Gönder">

</form>

<form action="?islem=liste" method="post">
    <input type="submit" value="Listele"">
</form>

<?php

    if ($_REQUEST['islem']=="ekle") {

        $full_name = $_REQUEST['full_name'];
        $email = $_REQUEST['email'];
        $gender = $_REQUEST['gender'];

        $sql = "SELECT * FROM students WHERE email= :email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            header("Location: Homework_Project.php?islem=hata ");

        } else {
            $sql = "INSERT INTO students (full_name,email,gender) VALUES ('$full_name','$email','$gender')";
            $db->exec($sql);
            echo "Ekleme Yapıldı<br>";

        }
}
?>

<?php

if($_REQUEST['islem']=="hata"){
    echo "Kullanıcı daha önce kayıt olmuştur";
}
?>

<?php
if ($_REQUEST['islem']=="liste"){

?>
<table border="1" width="400">
    <tr>
        <td>Adı Soyadı</td>
        <td>E-Mail</td>
        <td>Cinsiyet</td>

    </tr>

    <?php

        $sql="SELECT * FROM students";
        foreach ($db -> query($sql) as $item) {
            ?>


    <tr>
        <td><?=$item ['full_name'] ?></td>
        <td><?=$item ['email'] ?></td>
        <td><?=$item ['gender'] ?></td>

    </tr>
    <?php
        }
}
    ?>
</table>
</body>
</html>