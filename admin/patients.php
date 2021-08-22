<?php
include_once '../includes/header.php';
include_once '../includes/db.php';

if (!isset($_SESSION['userId'])) {
    header('location: ../index.php?m=Login to continue');
    exit;
}

if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    if (isset($_POST['checked']))
        $query = "UPDATE patient SET `checked` = 1 WHERE `id` = $pid ";
    else
        $query = "UPDATE patient SET `checked` = 0 WHERE `id` = $pid ";
    $result = mysqli_query($conn, $query);
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $department = $_POST['department'];
    $details = $_POST['details'];

    $query = "INSERT INTO patient (`name`, `address`, `department`, `details`) VALUES ('$name', '$address', '$department', '$details')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header('location: ./patients.php?m=New patient added');
    } else
        header('location: ./patients.php?m=Something went wrong');
}

$query = "SELECT * FROM patient";
$result = mysqli_query($conn, $query);

if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
?>
        <table class="patients-table">
            <tr>
                <td>Name: </td>
                <td><?php echo $row['address'] ?></td>
                <td>
                    <form action="#" method="post">
                        <input <?php if ($row['checked']) echo "checked" ?> onchange="this.form.submit()" type="checkbox" name="checked">
                        <input type="hidden" name="pid" value="<?php echo $row['id'] ?>">
                    </form>
                </td>
            </tr>
            <tr>
                <td>Department: </td>
                <td><?php echo $row['department'] ?></td>
            </tr>
            <tr>
                <td>Admission date: </td>
                <td><?php echo $row['date_added'] ?></td>
            </tr>
        </table>
<?php
    }
} else {
    echo ('<h1>No record found</h1>');
}
?>
<h1>Add new patient</h1>

<form style="margin-top: 20px;" id="insertform" action="#" method="post">
    <input required placeholder="Patient name" type="text" name="name"><br>
    <input required placeholder="Address" type="text" name="address"><br>
    <input required placeholder="Department" type="text" name="department">
    <input required placeholder="Details" type="text" name="details">
    <div><input type="submit" name="submit" value="Add"></div>
</form>
<p style="color: red; font-size: 20px; margin-top 15px;"><?php if (isset($_GET['m'])) echo ($_GET['m']) ?></p>

<?php
include_once '../includes/footer.php';
