<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";


if(!isset($_GET['id']))
{
    header("Location: customers.php");
    exit();
}


$id = intval($_GET['id']);



$message = "";


// Get customer details

$result = mysqli_query(
    $conn,
    "SELECT * FROM customers WHERE id='$id'"
);


$customer = mysqli_fetch_assoc($result);



if(!$customer)
{
    header("Location: customers.php");
    exit();
}




// Update customer


if(isset($_POST['update_customer']))
{

    $name = mysqli_real_escape_string(
        $conn,
        $_POST['name']
    );


    $phone = mysqli_real_escape_string(
        $conn,
        $_POST['phone']
    );


    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );


    $address = mysqli_real_escape_string(
        $conn,
        $_POST['address']
    );


    $credit_limit = mysqli_real_escape_string(
        $conn,
        $_POST['credit_limit']
    );


    $status = $_POST['status'];



    $update = "

    UPDATE customers SET

    name='$name',
    phone='$phone',
    email='$email',
    address='$address',
    credit_limit='$credit_limit',
    status='$status'

    WHERE id='$id'

    ";



    if(mysqli_query($conn,$update))
    {

        $message = "

        <div class='alert success'>
        Customer information updated successfully.
        </div>

        ";

        
        // refresh data

        $result = mysqli_query(
            $conn,
            "SELECT * FROM customers WHERE id='$id'"
        );

        $customer = mysqli_fetch_assoc($result);

    }
    else
    {

        $message = "

        <div class='alert error'>
        Update failed.
        </div>

        ";

    }


}




// Reset password


if(isset($_POST['reset_password']))
{


    $new_password = "CB".rand(1000,9999);


    $hashed_password = password_hash(
        $new_password,
        PASSWORD_DEFAULT
    );



    mysqli_query(
        $conn,
        "
        UPDATE customers SET
        password='$hashed_password'
        WHERE id='$id'
        "
    );



    $message = "

    <div class='alert success'>

    Password Reset Successful.

    <br><br>

    New Password:

    <b>$new_password</b>

    </div>

    ";


}



?>



<div class="content">


<div class="page-header">


<h2>Edit Customer</h2>


<a href="customers.php" class="btn btn-secondary">
Back
</a>


</div>



<?= $message ?>



<div class="card">



<form method="POST">



<div class="form-group">

<label>
Customer ID
</label>

<input 
type="text"
value="<?= $customer['customer_code']; ?>"
readonly>

</div>




<div class="form-group">

<label>
Customer Name
</label>


<input
type="text"
name="name"
value="<?= htmlspecialchars($customer['name']); ?>"
required>


</div>




<div class="form-group">

<label>
Phone Number
</label>


<input
type="text"
name="phone"
value="<?= htmlspecialchars($customer['phone']); ?>"
required>


</div>




<div class="form-group">

<label>
Email
</label>


<input
type="email"
name="email"
value="<?= htmlspecialchars($customer['email']); ?>"
required>


</div>




<div class="form-group">

<label>
Address
</label>


<textarea name="address">

<?= htmlspecialchars($customer['address']); ?>

</textarea>


</div>




<div class="form-group">

<label>
Credit Limit
</label>


<input
type="number"
step="0.01"
name="credit_limit"
value="<?= $customer['credit_limit']; ?>"
required>


</div>




<div class="form-group">

<label>
Account Status
</label>


<select name="status">


<option value="active"
<?php if($customer['status']=="active") echo "selected"; ?>>

Active

</option>



<option value="inactive"
<?php if($customer['status']=="inactive") echo "selected"; ?>>

Inactive

</option>


</select>


</div>





<button
type="submit"
name="update_customer"
class="btn btn-primary">

Save Changes

</button>



</form>




<hr>




<form method="POST">


<button
type="submit"
name="reset_password"
class="btn btn-warning">

Reset Customer Password

</button>


</form>



</div>


</div>
