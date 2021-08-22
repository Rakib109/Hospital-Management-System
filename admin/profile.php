<?php
include_once '../includes/header.php';
include_once '../includes/db.php';

if (!isset($_SESSION['userId'])) {
    header('location: ../index.php?m=Login to continue');
    exit;
}

$id = $_SESSION['userId'];
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    $query = "UPDATE admins SET `name` = '$name', `contact` = '$contact', `address` = '$address' WHERE `id` = $id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header('location: ./home.php?m=Profile updated');
    } else
        header('location: ./home.php?m=Something went wrong');
}

$query = "SELECT * FROM admins WHERE id = '$id' ";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$name = $row['name'];
$contact = $row['contact'];
$email = $row['email'];
$address = $row['address'];
?>

<h1>Admin profile</h1>

<form style="margin-top: 20px;" id="updateform" action="#" method="post">
    <input value="<?php echo $name ?>" required placeholder="Employee name" type="text" name="name"><br>
    <input value="<?php echo $contact ?>" required placeholder="Contact number" type="text" name="contact"><br>
    <input value="<?php echo $email ?>" disabled required placeholder="Email" type="text" name="email"><br>
    <input value="<?php echo $address ?>" required placeholder="Address" type="text" name="address"><br>
    <div><input type="submit" name="submit" value="Update"></div>
</form>
<a style="font-size: 30px; text-decoration: none;" href="./changepw.php">Change password</a>
<p style="color: red; font-size: 20px; margin-top 15px;"><?php if (isset($_GET['m'])) echo ($_GET['m']) ?></p>

<?php
include_once '../includes/footer.php';
