<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "ccms";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>
<?php

// Database configuration

$host = "localhost";

$username = "root";

$password = "";

$database = "ccms";




// Create database connection

$conn = mysqli_connect(

    $host,

    $username,

    $password,

    $database

);




// Check connection

if(!$conn)
{

    die(

        "Database connection failed: "

        . mysqli_connect_error()

    );

}



// Set character encoding

mysqli_set_charset(

    $conn,

    "utf8mb4"

);


?>
