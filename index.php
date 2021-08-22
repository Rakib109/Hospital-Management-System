<?php
include_once './includes/header.php';
include_once './includes/db.php';

if (isset($_SESSION['userId'])) {
    header('location: ./admin/home.php');
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM admins WHERE email = '$email' ";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 0) {
        header('location: ./index.php?m=No email found');
        exit;
    }

    $row = mysqli_fetch_array($result);
    if (password_verify($password, $row['password'])) {
        $_SESSION['userId'] = $row['id'];
        header('location: ./admin/home.php');
    } else
        header('location: ./index.php?m=Incorrect password');
}

?>
<h1>Admin Panel - Login</h1>

<form id="loginform" action="#" method="post">
    <input required placeholder="Email" type="text" name="email"><br>
    <input required placeholder="Password" type="password" name="password"><br>
    <a style="font-size: 24px; margin-right: 59px;" href="./admin/register.php">Create an account</a>
    <input type="submit" value="Login" name="submit">
    <p style="color: red; font-size: 30px;"><?php if (isset($_GET['m'])) echo ($_GET['m']) ?></p>
</form>

<script>
    document.getElementById("loginform").addEventListener("submit", validate)

    function validate(event) {
        const email = document.getElementsByName("email")[0].value
        const password = document.getElementsByName("password")[0].value
        const errMsg = document.querySelector("#loginform p")
        if (!email.includes('@')) {
            errMsg.textContent = "Invalid email"
            event.preventDefault()
        } else if (password.length < 6) {
            errMsg.textContent = "Password too short"
            event.preventDefault()
        }
    }
</script>

<?php
include_once './includes/footer.php';
