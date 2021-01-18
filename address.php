<?php
    session_start();
    require_once "configuration.php";
    if(isset($_POST['save_address']))
    {
        $address1=$_POST['address'];
        $address=$pdo->prepare("UPDATE register_table SET user_address = :user_address WHERE user_name=:user_name");
        $address->execute(array(':user_address' => $address1,':user_name' =>$_SESSION['u_name']));
        header('Location: book_item.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>address</title>
    <link rel="stylesheet" type="text/css" href="style13.css">
</head>
<body>

<form acion="address.php" method="post">
    <div class="address-form">
        <h1>Provide delivery address...</h1>
            <div class="fields">
                <div class="address-field"><input type="text" name="address" class="user-input" required="required" placeholder="Enter address"/></div>
            </div>  
                <button type="submit" name="save_address" class="address-box" ><h3>Place Order</h3></button>

</div> 
</form>
</body>
</html>