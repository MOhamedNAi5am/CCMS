<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";


$message = "";




// Get current settings

$setting_query = mysqli_query(

$conn,

"SELECT * FROM settings LIMIT 1"

);



$settings = mysqli_fetch_assoc($setting_query);






if(isset($_POST['update_settings']))
{


    $business_name = mysqli_real_escape_string(

        $conn,

        $_POST['business_name']

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






    $update = mysqli_query(

        $conn,

        "

        UPDATE settings SET

        business_name='$business_name',

        phone='$phone',

        email='$email',

        address='$address'

        WHERE id=1

        "

    );





    if($update)

    {


        $message = "

        <div class='alert success'>

        Settings updated successfully.

        </div>

        ";



        $setting_query = mysqli_query(

            $conn,

            "SELECT * FROM settings LIMIT 1"

        );


        $settings=mysqli_fetch_assoc($setting_query);


    }

    else

    {


        $message = "

        <div class='alert error'>

        Failed to update settings.

        </div>

        ";

    }


}



?>




<div class="content">



<div class="page-header">


<h2>

System Settings

</h2>



</div>





<?= $message ?>






<div class="card">


<form method="POST">






<div class="form-group">


<label>

Business Name

</label>


<input

type="text"

name="business_name"

value="<?= htmlspecialchars($settings['business_name']); ?>"

required>


</div>







<div class="form-group">


<label>

Phone Number

</label>


<input

type="text"

name="phone"

value="<?= htmlspecialchars($settings['phone']); ?>"

required>


</div>







<div class="form-group">


<label>

Email

</label>


<input

type="email"

name="email"

value="<?= htmlspecialchars($settings['email']); ?>">


</div>







<div class="form-group">


<label>

Address

</label>


<textarea

name="address">

<?= htmlspecialchars($settings['address']); ?>

</textarea>


</div>








<button

type="submit"

name="update_settings"

class="btn btn-primary">


Save Settings


</button>





</form>



</div>





</div>
