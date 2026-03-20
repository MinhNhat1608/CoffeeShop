<?php

include("config/database.php");
include("../includes/header.php");

if(isset($_POST['register'])){

$username = $_POST['username'];
$password = $_POST['password'];

$query = "INSERT INTO users(username,password)
VALUES('$username','$password')";

mysqli_query($conn,$query);

echo "Register success";

}

?>

<form method="POST">
<input type="text" name="username">
<input type="password" name="password">
<button name="register">Register</button>

</form>
<?php include("../includes/footer.php"); ?>