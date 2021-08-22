<?php
include_once '../includes/header.php';
include_once '../includes/db.php';

if (!isset($_SESSION['userId'])) {
    header('location: ../index.php?m=Login to continue');
    exit;
}

$id = $_GET['id'];
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $department = $_POST['department'];
    $role = $_POST['role'];
    $location = $_POST['location'];

    $query = "UPDATE staff SET `name` = '$name', `contact` = '$contact', `department` = '$department', `role` = '$role', `location` = '$location' WHERE `id` = $id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header('location: ../admin/home.php?m=Employee info updated');
    } else
        header('location: ./update.php?m=Something went wrong');
}

if (isset($_POST['delete'])) {
    $query = "DELETE FROM staff WHERE `id` = $id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header('location: ../admin/home.php?m=Employee info deleted');
    } else
        header('location: ./update.php?m=Something went wrong');
}

$query = "SELECT * FROM staff WHERE id = '$id' ";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$name = $row['name'];
$contact = $row['contact'];
$department = $row['department'];
$location = $row['location'];
$joining_date = $row['joining_date'];
$role = $row['role'];
?>

<h1>Update or delete employee info</h1>

<form style="margin-top: 20px;" id="updateform" action="#" method="post">
    <input value="<?php echo $name ?>" required placeholder="Employee name" type="text" name="name"><br>
    <input value="<?php echo $contact ?>" required placeholder="Contact number" type="text" name="contact"><br>
    <input value="<?php echo $role ?>" required placeholder="Role (Doctor/Nurse)" type="text" name="role"><br>
    <input value="<?php echo $department ?>" required placeholder="Department" type="text" name="department"><br>
    <input value="<?php echo $location ?>" required placeholder="Location" type="text" name="location"><br>
    <input disabled value=" Joining date: <?php echo $joining_date ?>">
    <div><input type="submit" name="submit" value="Update"></div>
</form>
<form id="deleteform" action="#" method="post">
    <input name="delete" type="submit" value="Delete">
</form>
<p style="color: red; font-size: 20px; margin-top 15px;"><?php if (isset($_GET['m'])) echo ($_GET['m']) ?></p>

<?php
include_once '../includes/footer.php';
