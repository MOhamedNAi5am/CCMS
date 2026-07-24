<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($pageTitle)) {
    $pageTitle = "Coastal Blue CCMS";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="#">
            Coastal Blue CCMS
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarMenu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav ms-auto">

                <?php if(isset($_SESSION['user_id'])): ?>

                    <li class="nav-item">

                        <span class="nav-link">

                            <i class="bi bi-person-circle"></i>

                            <?php echo htmlspecialchars($_SESSION['name']); ?>

                        </span>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" href="../auth/change_password.php">

                            <i class="bi bi-key"></i>

                            Change Password

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link text-warning" href="../auth/logout.php">

                            <i class="bi bi-box-arrow-right"></i>

                            Logout

                        </a>

                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</nav>

<div class="container-fluid mt-4">