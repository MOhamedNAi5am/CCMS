<?php

session_start();

require_once "../config/database.php";


$error = "";



if(isset($_POST['login']))
{


    $username = mysqli_real_escape_string(

        $conn,

        $_POST['username']

    );


    $password = $_POST['password'];





    $query = mysqli_query(

        $conn,

        "

        SELECT *

        FROM admins

        WHERE username='$username'

        "

    );





    if(mysqli_num_rows($query)>0)

    {


        $admin = mysqli_fetch_assoc($query);




        if(password_verify($password,$admin['password']))

        {


            $_SESSION['admin_id'] = $admin['id'];

            $_SESSION['admin_name'] = $admin['name'];



            header(

                "Location: dashboard.php"

            );


            exit();


        }

        else

        {


            $error = "Incorrect password.";

        }



    }

    else

    {


        $error = "Admin account not found.";

    }



}



?>





<!DOCTYPE html>

<html lang="en">


<head>


<meta charset="UTF-8">


<title>

Admin Login - CCMS

</title>



<link rel="stylesheet"

href="../assets/css/style.css">



</head>




<body class="login-page">





<div class="login-box">


<h2>

Admin Login

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

Username

</label>


<input

type="text"

name="username"

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
