<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";

$message = "";


if(isset($_POST['add_customer']))
{

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);
    $credit_limit = mysqli_real_escape_string($conn,$_POST['credit_limit']);


    // Generate customer login ID

    $customer_id = "CUS".rand(10000,99999);


    // Default password

    $password = "CB".rand(1000,9999);


    // Encrypt password

    $hashed_password = password_hash($password,PASSWORD_DEFAULT);



    $check = mysqli_query(
        $conn,
        "SELECT * FROM customers 
         WHERE email='$email'"
    );


    if(mysqli_num_rows($check)>0)
    {

        $message = "
        <div class='alert error'>
        Email already exists.
        </div>";

    }

    else
    {


        $query="
        INSERT INTO customers
        (
        customer_code,
        name,
        phone,
        email,
        address,
        credit_limit,
        password,
        status
        )

        VALUES

        (

        '$customer_id',
        '$name',
        '$phone',
        '$email',
        '$address',
        '$credit_limit',
        '$hashed_password',
        'active'

        )
        ";



        if(mysqli_query($conn,$query))
        {


            $message = "

            <div class='alert success'>

            Customer Added Successfully.
            <br><br>

            <b>Customer Login ID:</b>
            $customer_id

            <br>

            <b>Temporary Password:</b>
            $password

            </div>

            ";


        }

        else
        {

            $message="
            <div class='alert error'>
            Failed to add customer.
            </div>";

        }


    }


}


?>


<div class="content">


<div class="page-header">

<h2>Add New Customer</h2>


<a href="customers.php" class="btn btn-secondary">
Back
</a>


</div>



<?= $message ?>



<div class="card">


<form method="POST">



<div class="form-group">

<label>
Customer Name
</label>

<input 
type="text"
name="name"
required>

</div>




<div class="form-group">

<label>
Phone Number
</label>

<input 
type="text"
name="phone"
required>

</div>




<div class="form-group">

<label>
Email Address
</label>

<input 
type="email"
name="email"
required>

</div>




<div class="form-group">

<label>
Address
</label>

<textarea 
name="address"
required></textarea>

</div>




<div class="form-group">

<label>
Credit Limit (MVR)
</label>

<input 
type="number"
name="credit_limit"
step="0.01"
required>

</div>




<button 
type="submit"
name="add_customer"
class="btn btn-primary">

Create Customer Account

</button>



</form>



</div>



</div>
