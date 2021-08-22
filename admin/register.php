<?php
include_once '../includes/db.php';
include_once '../includes/header.php';

if (isset($_SESSION['userId']))
    header('location: ./home.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $query = "SELECT * FROM admins WHERE email = '$email' ";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) !== 0) {
        header('location: ./register.php?m=Mail already in use');
        exit;
    }

    $hashedPw = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO admins (`email`, `name`, `address`, `password`) VALUES ('$email', '$name', '$address', '$hashedPw')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $_SESSION['userId'] = mysqli_insert_id($conn);
        header('location: ./home.php');
    } else
        header('location: ./register.php?m=Something went wrong');
}
?>

<h1 style="margin: 20px;">Admin Panel - Registration</h1>

<form id="regform" action="#" method="post">
    <input required placeholder="Admin name" type="text" name="name"><br>
    <input required placeholder="Email" type="text" name="email"><br>
    <input required placeholder="Address" type="text" name="address"><br>
    <input required placeholder="Password" type="password" name="password"><br>
    <input required placeholder="Password (again)" type="password" name="password2"><br>
    <a style="font-size: 24px; margin-right: 30px;" href="../">Already have an account?</a>
    <input type="submit" value="register" name="submit">
    <p style="color: red; font-size: 30px;"><?php if (isset($_GET['m'])) echo ($_GET['m']) ?></p>
</form>

<script>
    document.getElementById("regform").addEventListener("submit", validate)

    function validate(event) {
        const adminName = document.getElementsByName("name")[0].value
        const email = document.getElementsByName("email")[0].value
        const password = document.getElementsByName("password")[0].value
        const password2 = document.getElementsByName("password2")[0].value
        const errMsg = document.querySelector("#regform p")
        if (!email.includes('@')) {
            errMsg.textContent = "Invalid email"
            event.preventDefault()
        } else if (password.length < 6) {
            errMsg.textContent = "Password too short"
            event.preventDefault()
        } else if (password !== password2) {
            errMsg.textContent = "Passwords do not match"
            event.preventDefault()
        }
    }
</script>

<?php
include_once '../includes/footer.php';
