<?php
include_once '../includes/header.php';
include_once '../includes/db.php';

if (!isset($_SESSION['userId'])) {
    header('location: ../index.php?m=Login to continue');
    exit;
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $department = $_POST['department'];
    $role = $_POST['role'];
    $location = $_POST['location'];

    $query = "INSERT INTO staff (`name`, `contact`, `department`, `location`, `role`) VALUES ('$name', '$contact', '$department', '$location', '$role')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header('location: ../admin/home.php?m=New employee info added');
    } else
        header('location: ./insert.php?m=Something went wrong');
}

?>

<h1>Add new employee</h1>

<form style="margin-top: 20px;" id="insertform" action="#" method="post">
    <input required placeholder="Employee name" type="text" name="name"><br>
    <input required placeholder="Contact number" type="text" name="contact"><br>
    <input required placeholder="Role (Doctor/Nurse)" type="text" name="role"><br>
    <input required placeholder="Department" type="text" name="department"><br>
    <input required placeholder="Location" type="text" name="location">
    <div><input type="submit" name="submit" value="Add"></div>
</form>
<p style="color: red; font-size: 20px; margin-top 15px;"><?php if (isset($_GET['m'])) echo ($_GET['m']) ?></p>

<?php
include_once '../includes/footer.php';
