<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCMS Admin Panel</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="wrapper">

    <!-- Sidebar -->
    <aside class="sidebar">

        <div class="logo">
            <h2>CCMS</h2>
            <small>Coastal Blue</small>
        </div>

        <ul class="menu">

            <li>
                <a href="dashboard.php">
                    🏠 Dashboard
                </a>
            </li>

            <li>
                <a href="customers.php">
                    👥 Customers
                </a>
            </li>

            <li>
                <a href="transactions.php">
                    💳 Transactions
                </a>
            </li>

            <li>
                <a href="reports.php">
                    📊 Reports
                </a>
            </li>

            <li>
                <a href="settings.php">
                    ⚙ Settings
                </a>
            </li>

            <li>
                <a href="logout.php">
                    🚪 Logout
                </a>
            </li>

        </ul>

    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <header class="topbar">

            <div>
                <h2>Customer Credit Management System</h2>
            </div>

            <div class="user-info">
                Welcome,
                <strong>
                    <?= htmlspecialchars($_SESSION['admin_name']); ?>
                </strong>
            </div>

        </header>
        