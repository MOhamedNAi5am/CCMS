<?php

session_start();

require_once "../config/database.php";


$error = "";



if(isset($_POST['login']))
{


    $customer_code = mysqli_real_escape_string(
        $conn,
        $_POST['customer_code']
    );


    $password = $_POST['password'];




    $query = mysqli_query(

        $conn,

        "

        SELECT *

        FROM customers

        WHERE customer_code='$customer_code'

        AND status='active'

        "

    );




    if(mysqli_num_rows($query)>0)

    {


        $customer = mysqli_fetch_assoc($query);




        if(password_verify($password,$customer['password']))

        {


            $_SESSION['customer_id'] = $customer['id'];

            $_SESSION['customer_name'] = $customer['name'];

            $_SESSION['customer_code'] = $customer['customer_code'];



            header(

                "Location: dashboard.php"

            );


            exit();



        }

        else

        {


            $error = "Invalid password.";

        }



    }

    else

    {


        $error = "Customer account not found.";

    }



}



?>



<!DOCTYPE html>

<html>

<head>


<title>

Customer Login - CCMS

</title>


<link rel="stylesheet" href="../assets/css/style.css">


</head>



<body class="login-page">





<div class="login-box">


<h2>

Customer Login

</h2>




<?php

if($error!="")

{

?>

<div class="alert error">

<?= $error; ?>

</div>


<?php

}

?>





<form method="POST">





<div class="form-group">


<label>

Customer ID

</label>


<input

type="text"

name="customer_code"

placeholder="Example: CUS12345"

required>


</div>







<div class="form-group">


<label>

Password

</label>


<input

type="password"

name="password"

required>


</div>







<button

type="submit"

name="login"

class="btn btn-primary">


Login


</button>





</form>




</div>





</body>

</html>
