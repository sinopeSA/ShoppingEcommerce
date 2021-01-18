<?php
    session_start();
    require_once "header.php";

    $sucess_message = 0;
    if(isset($_SESSION['u_name']))
    {
        if(isset($_POST['product_id_remove'])){
            $remove_item_query = $pdo->prepare("DELETE FROM customer_cart WHERE product_id = :product_id AND user_name = :user");
            $remove_item_query ->execute(array(':product_id' => $_POST['product_id_remove'],':user' => $_SESSION['u_name']));

            $product_quentity_inc = $pdo->prepare("UPDATE sport_acc SET Quantity = Quantity + 1 WHERE product_id = :product_id");
            $product_quentity_inc -> execute(array(':product_id' => $_POST['product_id_remove']));
            $sucess_message = 1;
        }
    }
    if(isset($_POST['add_address'])){
        header('Location: address.php');
    }
?>

<div class="container w-70">
    <nav class="navbar bg-success navbar-default fixed-top">
    <a href="homepage.php" class ="navbar-brand">
            <h3 class="px-2">
                <i class="fas fa-shopping-basket text-info"></i><span class ="text-dark ml-2">Shopping Cart</span>
            </h3> 
    </a>
    <h3 class = "text-success">
        <?php if($sucess_message == 1)
            {
                echo "<script>swal('Item Removed By The Cart','','success')</script>";
            }
        ?></h3>
    <?php
        if(isset($_SESSION['u_name'])){
            echo '<h3 style="position:absolute;top:1rem;left:45%"class="text-dark mr-4">Welcome : '.$_SESSION['u_name'].'</h3>';
        }
    ?>
    <form method = "post" action="login.php">
                             <button style="position:absolute;top:1rem;left:95%"type="submit" class ="btn btn-danger" name="logout"> Log Out</button>
                          </form>
    </nav> 
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart pt-2">
                <h3 class = "text-dark mt-3" style="padding-top:10rem;">My cart</h6>
                <hr class="text-white">
                <?php
                    $total = 0;
                    if(isset($_SESSION['u_name']))
                    {
                        $cart_items_count = $pdo->prepare("SELECT count(*) AS item_count FROM customer_cart WHERE user_name = :user");
                        $cart_items_count->execute(array(':user' => $_SESSION['u_name']));
                        $fetch_cart_items_count = $cart_items_count->fetch(PDO::FETCH_ASSOC);
                        if($fetch_cart_items_count['item_count']<1){
                            echo "<h2 class='text-dark mt-5 pt-3 pl-5 ml-3'>Cart is Empty</h2>";
                        }
                        $cart_items = $pdo->prepare("SELECT * FROM customer_cart WHERE user_name = :user");
                        $cart_items->execute(array(':user' => $_SESSION['u_name']));
                        while($fetch_cart_items = $cart_items->fetch(PDO::FETCH_ASSOC))
                        {
                            cart_element($fetch_cart_items['product_image'],$fetch_cart_items['product_name'],$fetch_cart_items['price'],$fetch_cart_items['actual_price'],$fetch_cart_items['product_id']);
                            $total = $total + (int)$fetch_cart_items['price'];
                        }
                    }
                    else{
                        echo "<h2 class='text-warning mt-5 pt-3 pl-5 ml-3'>Log in to View the cart item</h2>";
                    }
                ?>
            </div>
        </div>
        <?php
        if(isset($_SESSION['u_name']))
        {
        echo '<div class="col-md-4 offset-md-1 border-rounded bg-white h-25 float-right" style="margin-top:11.8%">';
            echo '<div class="pt-4">';
                echo '<h6>Price Details</h6>
                <hr>
                <div class="row price-details p-2">
                    <div class="col-md-6">';
                            if(isset($_SESSION["u_name"])){
                                $count = $pdo->prepare("SELECT COUNT(product_id) AS productidunique FROM customer_cart WHERE user_name = :user");
                                $count->execute(array(":user" => $_SESSION["u_name"]));
                                $count_number = $count->fetch(PDO::FETCH_ASSOC);
                                echo "<h6>Price (".$count_number["productidunique"]." items)</h6>";
                            }
                       echo'<h5>Delivary charges</h5>
                        <hr>
                        <h6>Amount Payable</h6>
                    </div>
                    <div class="col-md-6 p-1">
                        <h6>₹ '.$total.'</h6>
                        <h6 class="text-success">FREE</h6>
                        <hr>
                        <h6>₹'. $total.'</h6>
                    </div>
                </div>';
           echo'</div>
               
          </div>
          
        </div>
        <form acion="cart_item.php" method="post">
            <button type="submit" name="add_address" class="btn btn-success" style="margin-left:90rem;margin-top:5rem;padding-left:5rem;padding-bottom:2rem;padding-right:5rem;padding-top:2rem;"><h3>Reserve</h3></button>
        </form>
    </div>';
}

?>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
    