<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Customer Portal</title>

<link rel="stylesheet"
href="../assets/css/style.css">

</head>

<body>

<header class="customer-header">

    <div class="logo">

        <h2>Coastal Blue</h2>

    </div>

    <nav>

        <a href="dashboard.php">Dashboard</a>

        <a href="statement.php">Statement</a>

        <a href="profile.php">Profile</a>

        <a href="logout.php">Logout</a>

    </nav>

</header>
