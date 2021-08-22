<?php
session_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/management/includes/styles.css">
    <title>Admin Panel</title>
</head>

<body>
    <nav>
        <nav>
            <?php if (isset($_SESSION['userId'])) : ?>
                <a href="/management/admin/home.php">Home</a>
                <a href="/management/admin/profile.php">Profile</a>
                <a href="/management/admin/logout.php">Logout</a>
            <?php else : ?>
                <a href="/management/">Login</a>
                <a href="/management/admin/register.php">Register</a>
            <?php endif ?>
        </nav>
    </nav>