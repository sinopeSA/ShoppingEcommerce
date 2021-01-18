<div class="deliver_address" style="max-width:100%">
<nav class="navbar bg-success navbar-default fixed-top">   
<form method = "post" action="homepage.php">
                             <button style="position:absolute;top:1rem;left:85%"type="submit" class ="btn btn-danger" name="logout"> Home</button>
                          </form>                
            <form method = "post" action="login.php">
                             <button style="position:absolute;top:1rem;left:95%"type="submit" class ="btn btn-danger" name="logout"> Log Out</button>
                          </form>
    </nav>
<?php
session_start();
require_once "configuration.php";
require_once "delivery.php";

        $address_retrival=$pdo->prepare("SELECT * FROM register_table WHERE user_name=:user_name");
        $address_retrival->execute(array(':user_name' =>$_SESSION['u_name'])); 
        $fetch_address_retrival = $address_retrival ->fetch(PDO::FETCH_ASSOC);

        echo '
            <div>
                <h3>Your Item will be delivered soon to this address</h3>
                <h5>'.$fetch_address_retrival['user_name'].','.$fetch_address_retrival['user_address'].','.$fetch_address_retrival['p_number'].'</h5>
            </div>
        ';
?>
</div>