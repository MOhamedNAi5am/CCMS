<?php
session_start();

require_once "../config/database.php";

$error = "";

if (isset($_SESSION['user_id'])) {

    if ($_SESSION['role'] == "admin") {
        header("Location: ../admin/dashboard.php");
        exit();
    } else {
        header("Location: ../customer/dashboard.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {

        $error = "Please enter username and password.";

    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND status='active'");

        $stmt->bind_param("s", $username);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password_hash'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['customer_id'] = $user['customer_id'];
                $_SESSION['name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];

                $ip = $_SERVER['REMOTE_ADDR'];

                $log = $conn->prepare("INSERT INTO login_logs(user_id, ip_address) VALUES(?, ?)");

                $log->bind_param("is", $user['id'], $ip);

                $log->execute();

                if ($user['role'] == "admin") {

                    header("Location: ../admin/dashboard.php");

                } else {

                    header("Location: ../customer/dashboard.php");

                }

                exit();

            } else {

                $error = "Invalid username or password.";

            }

        } else {

            $error = "Invalid username or password.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>CCMS Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{

background:#f4f6f9;

}

.card{

border:none;

border-radius:15px;

box-shadow:0 5px 15px rgba(0,0,0,.15);

}

</style>

</head>

<body>

<div class="container">

<div class="row justify-content-center mt-5">

<div class="col-md-5">

<div class="card">

<div class="card-body">

<h2 class="text-center mb-4">

Coastal Blue CCMS

</h2>

<?php if($error!=""){ ?>

<div class="alert alert-danger">

<?php echo $error; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Username

</label>

<input
type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Password

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="d-grid">

<button
class="btn btn-primary"
type="submit">

Login

</button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
