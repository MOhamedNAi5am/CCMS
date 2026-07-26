<?php

$pageTitle = "Customer Management";

require_once "../config/auth.php";
require_once "../config/database.php";
require_once "../config/functions.php";

if ($_SESSION['role'] != "admin") {
    header("Location: ../auth/login.php");
    exit();
}

include "../includes/header.php";

/*
|--------------------------------------------------------------------------
| Customer Search
|--------------------------------------------------------------------------
*/

$search = "";

$sql = "
SELECT
    u.id,
    u.customer_id,
    u.full_name,
    u.phone,
    u.address,
    u.username,
    u.status,
    IFNULL(cb.current_balance,0) AS current_balance
FROM users u
LEFT JOIN customer_balances cb
ON cb.customer_id = u.id
WHERE u.role='customer'
";

if (isset($_GET['search']) && trim($_GET['search']) != "") {

    $search = trim($_GET['search']);

    $sql .= " AND (
        u.customer_id LIKE ?
        OR u.full_name LIKE ?
        OR u.phone LIKE ?
    )";

    $stmt = $conn->prepare($sql);

    $like = "%".$search."%";

    $stmt->bind_param("sss", $like, $like, $like);

} else {

    $stmt = $conn->prepare($sql);

}

$stmt->execute();

$customers = $stmt->get_result();

?>

<div class="container-fluid">

<div class="row">

<?php include "../includes/admin_sidebar.php"; ?>

<div class="col-md-9">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>

Customer Management

</h2>

<a href="add_customer.php"
class="btn btn-primary">

<i class="bi bi-person-plus-fill"></i>

Add Customer

</a>

</div>

<form method="GET" class="mb-4">

<div class="input-group">

<input
type="text"
name="search"
class="form-control"
placeholder="Search by Customer ID, Name or Phone"
value="<?php echo htmlspecialchars($search); ?>">

<button
class="btn btn-success"
type="submit">

Search

</button>

<a href="customers.php"
class="btn btn-secondary">

Reset

</a>

</div>

</form>

<div class="card shadow">

<div class="card-header bg-primary text-white">

Customer List

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead class="table-light">

<tr>

<th>Customer ID</th>

<th>Name</th>

<th>Phone</th>

<th>Username</th>

<th>Balance</th>

<th>Status</th>

<th width="180">

Actions

</th>

</tr>

</thead>

<tbody>
    <?php
require_once "../config/database.php";
require_once "../includes/admin_auth.php";

$query = "SELECT * FROM customers ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="content">

    <div class="page-header">
        <h2>Customer Management</h2>
        <a href="add_customer.php" class="btn btn-primary">
            + Add Customer
        </a>
    </div>


    <div class="card">

        <table class="table">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Credit Limit</th>
                    <th>Outstanding Balance</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>


            <tbody>

            <?php

            if(mysqli_num_rows($result) > 0)
            {

                while($customer = mysqli_fetch_assoc($result))
                {

                    $customer_id = $customer['id'];


                    // Calculate outstanding balance
                    $balance_query = "
                    SELECT 
                    SUM(amount) AS total 
                    FROM credit_transactions
                    WHERE customer_id='$customer_id'
                    AND type='credit'
                    ";


                    $balance_result = mysqli_query($conn,$balance_query);

                    $balance_data = mysqli_fetch_assoc($balance_result);

                    $credit_total = $balance_data['total'] ?? 0;



                    $payment_query = "
                    SELECT 
                    SUM(amount) AS paid 
                    FROM credit_transactions
                    WHERE customer_id='$customer_id'
                    AND type='payment'
                    ";


                    $payment_result = mysqli_query($conn,$payment_query);

                    $payment_data = mysqli_fetch_assoc($payment_result);

                    $payment_total = $payment_data['paid'] ?? 0;


                    $balance = $credit_total - $payment_total;


            ?>


                <tr>

                    <td>
                        <?= $customer['id']; ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($customer['name']); ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($customer['phone']); ?>
                    </td>


                    <td>
                        <?= htmlspecialchars($customer['email']); ?>
                    </td>


                    <td>
                        MVR <?= number_format($customer['credit_limit'],2); ?>
                    </td>


                    <td>

                        <?php if($balance > 0){ ?>

                            <span class="danger">
                                MVR <?= number_format($balance,2); ?>
                            </span>

                        <?php }else{ ?>

                            <span class="success">
                                Paid
                            </span>

                        <?php } ?>

                    </td>


                    <td>

                        <?php if($customer['status']=="active"){ ?>

                            <span class="badge active">
                                Active
                            </span>

                        <?php }else{ ?>

                            <span class="badge inactive">
                                Inactive
                            </span>

                        <?php } ?>

                    </td>


                    <td class="actions">


                        <a href="view_customer.php?id=<?=$customer['id'];?>"
                           class="btn btn-info">
                            View
                        </a>



                        <a href="edit_customer.php?id=<?=$customer['id'];?>"
                           class="btn btn-warning">
                            Edit
                        </a>



                        <a href="delete_customer.php?id=<?=$customer['id'];?>"
                           onclick="return confirm('Delete this customer?')"
                           class="btn btn-danger">
                            Delete
                        </a>


                    </td>


                </tr>


            <?php

                }

            }

            else

            {

            ?>

                <tr>

                    <td colspan="8" class="empty">

                        No customers registered yet.

                    </td>

                </tr>


            <?php

            }

            ?>


            </tbody>

        </table>


    </div>


</div>
