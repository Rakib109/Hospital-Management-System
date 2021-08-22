<?php
include_once '../includes/header.php';
include_once '../includes/db.php';

if (!isset($_SESSION['userId'])) {
    header('location: ../index.php?m=Login to continue');
    exit;
}

$id = $_SESSION['userId'];
if (isset($_POST['update'])) {
    $oldpassword = $_POST['oldpassword'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    if ($password !== $password2) {
        header('location: ./changepw.php?m=Passwords do not match');
        exit;
    }
    $query = "SELECT * FROM admins WHERE id = '$id' ";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_array($result);
    if (password_verify($oldpassword, $row['password'])) {
        $hashedPw = password_hash($password2, PASSWORD_DEFAULT);
        $query = "UPDATE admins SET `password` = '$hashedPw' WHERE id = $id";
        $result = mysqli_query($conn, $query);
        header('location: ./changepw.php?m=Password updated');
    } else
        header('location: ./changepw.php?m=Incorrect current password');
    exit;
}

?>
<h1>Update password</h1>

<form id="loginform" action="#" method="post">
    <input required placeholder="Current password" type="password" name="oldpassword"><br>
    <input required placeholder="New password" type="password" name="password"><br>
    <input required placeholder="New password (again)" type="password" name="password2"><br>
    <input type="submit" value="Update" name="update">
    <p style="color: red; font-size: 30px;"><?php if (isset($_GET['m'])) echo ($_GET['m']) ?></p>
</form>

<?php
include_once '../includes/footer.php';
