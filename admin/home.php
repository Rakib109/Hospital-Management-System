<?php
include_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = "SELECT * FROM staff";
    $result = mysqli_query($conn, $query);

    // Return false if no result found
    if (mysqli_num_rows($result) === 0) {
        echo json_encode(array("failed" => true, "m" => "No employee info found"));
        exit;
    }

    $response = array();
    while ($row = mysqli_fetch_assoc($result))
        $response[] = $row;

    echo json_encode($response);
    exit;
}

include_once '../includes/header.php';
if (!isset($_SESSION['userId'])) {
    header('location: ../index.php?m=Login to continue');
    exit;
}
?>

<div style="margin-top: 20px;" class="admin">
    <h1>Admin Dashboard</h1>
    <a href="./patients.php"><button>Patient list</button></a>
    <div><a href="../employees/insert.php"><button>Add new employee</button></a></div>
    <div><button id="view-employees">View all employees</button></div>
    <p class="no-info" style="color: blue; font-size: 20px; margin-top: 15px;"><?php if (isset($_GET['m'])) echo ($_GET['m']) ?></p>

    <div id="viewall">

    </div>

</div>

<script>
    document.getElementById("view-employees").addEventListener("click", () => {
        const req = new XMLHttpRequest();
        req.open("POST", "./home.php");
        req.responseType = "json";
        req.onreadystatechange = () =>
            req.readyState === 4 && appendResult(req.response);
        req.send();
    })

    function appendResult(response) {
        if (response.failed)
            document.querySelector(".no-info").textContent = response.m
        else {
            const viewall = document.getElementById("viewall")
            viewall.innerHTML = ""
            response.forEach(row => {
                const a = document.createElement("a")
                a.href = `../employees/update.php?id=${row.id}`
                a.innerHTML = `
                <div class="container">
                    <div>
                        <h2>${row.name}</h2>
                        <h2><i>${row.role}</i></h2>
                    </div>
                    <div style="display: flex;">
                        <p>Contact: </p>
                        <p>${row.contact}</p>
                    </div>
                    <div>
                        <p>Department: </p>
                        <p>${row.department}</p>
                    </div>
                </div>
            `
                viewall.appendChild(a)
            });
        }
    }
</script>

<?php
include_once '../includes/footer.php';
