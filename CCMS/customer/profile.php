<?php

session_start();

require_once "../config/database.php";



// Check login

if(!isset($_SESSION['customer_id']))
{
    header("Location: login.php");
    exit();
}



$customer_id = $_SESSION['customer_id'];

$message = "";




// Get customer information

$result = mysqli_query(

$conn,

"

SELECT *

FROM customers

WHERE id='$customer_id'

"

);



$customer = mysqli_fetch_assoc($result);





// Change password


if(isset($_POST['change_password']))
{


    $old_password = $_POST['old_password'];

    $new_password = $_POST['new_password'];

    $confirm_password = $_POST['confirm_password'];





    if(password_verify($old_password,$customer['password']))

    {


        if($new_password == $confirm_password)

        {


            $hashed_password = password_hash(

                $new_password,

                PASSWORD_DEFAULT

            );



            mysqli_query(

                $conn,

                "

                UPDATE customers

                SET password='$hashed_password'

                WHERE id='$customer_id'

                "

            );



            $message = "

            <div class='alert success'>

            Password changed successfully.

            </div>

            ";



        }

        else

        {


            $message = "

            <div class='alert error'>

            New passwords do not match.

            </div>

            ";


        }


    }

    else

    {


        $message = "

        <div class='alert error'>

        Current password is incorrect.

        </div>

        ";


    }



}




?>





<!DOCTYPE html>

<html>

<head>


<title>

My Profile - CCMS

</title>


<link rel="stylesheet" href="../assets/css/style.css">


</head>



<body>




<?php include "../includes/customer_header.php"; ?>






<div class="content">





<div class="page-header">


<h2>

My Profile

</h2>



<a href="dashboard.php"

class="btn btn-secondary">

Back

</a>



</div>





<?= $message ?>







<div class="card">



<h3>

Customer Information

</h3>





<table class="details">


<tr>

<td>

Customer ID

</td>


<td>

<?= $customer['customer_code']; ?>

</td>


</tr>




<tr>

<td>

Name

</td>


<td>

<?= htmlspecialchars($customer['name']); ?>

</td>


</tr>





<tr>

<td>

Phone Number

</td>


<td>

<?= htmlspecialchars($customer['phone']); ?>

</td>


</tr>





<tr>

<td>

Email

</td>


<td>

<?= htmlspecialchars($customer['email']); ?>

</td>


</tr>





<tr>

<td>

Address

</td>


<td>

<?= htmlspecialchars($customer['address']); ?>

</td>


</tr>






</table>


</div>









<div class="card">


<h3>

Change Password

</h3>




<form method="POST">






<div class="form-group">


<label>

Current Password

</label>


<input

type="password"

name="old_password"

required>


</div>







<div class="form-group">


<label>

New Password

</label>


<input

type="password"

name="new_password"

required>


</div>







<div class="form-group">


<label>

Confirm New Password

</label>


<input

type="password"

name="confirm_password"

required>


</div>







<button

type="submit"

name="change_password"

class="btn btn-primary">


Update Password


</button>





</form>



</div>






</div>





</body>

</html>
