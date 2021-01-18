<?php
    session_start();
    require_once "header.php";

    $added_item = 0;
    
    if(isset($_POST['add_to_cart']))
    {
        if(isset($_SESSION['u_name']))
        {
            $productidunique = $pdo->prepare("SELECT COUNT(product_id) AS productidunique FROM customer_cart WHERE product_id = :product_id AND user_name = :user");
            $productidunique->execute(array(':product_id' => $_POST['product_id'],':user' => $_SESSION['u_name']));
            $fetch_unique_of_product_id = $productidunique->fetch(PDO::FETCH_ASSOC);

            if($fetch_unique_of_product_id['productidunique']<1)
            {
                $first_query = $pdo->prepare("SELECT product_id, product_name, Quantity, actual_price, price, product_image FROM sport_acc WHERE product_id =:product_id");
                $first_query -> execute(array(':product_id' => $_POST['product_id']));
                $fetch_first_query = $first_query->fetch(PDO::FETCH_ASSOC);

                $second_query = $pdo->prepare("INSERT INTO customer_cart(product_id, product_name, actual_price, price, product_image, user_name) 
                                VALUES (:product_id, :product_name, :actual_price, :price, :product_image, :user)");
                $second_query -> execute(array(':product_id' => $fetch_first_query['product_id'],
                                            ':product_name' => $fetch_first_query['product_name'], 
                                            ':actual_price' => $fetch_first_query['actual_price'],
                                            ':price' => $fetch_first_query['price'],
                                            ':product_image' => $fetch_first_query['product_image'],
                                            ':user' => $_SESSION['u_name']));  

                $third_query = $pdo->prepare("UPDATE sport_acc SET Quantity = Quantity - 1 WHERE product_id = :product_id");
                $third_query -> execute(array(':product_id' => $_POST['product_id']));
                echo '<script>swal("Item Successfully Added to the cart","","success")</script>';
            }   
            else{
                 echo '<script>swal("Sorry!!","Item is alredy there in the cart","warning")</script>';
               
            }      
        }
        else{
            echo '<script>swal("Something wrong!!","Please login to the website to buy the products","warning")</script>';
        }   
    }
    

?>
<div class="container" style="max-width:100%">
    <div class="row text-center pl-1 ml-4 mt-4 pt-5">
    <nav class="navbar bg-success navbar-default fixed-top">   
        <?php
            if(isset($_SESSION['u_name'])){
            $productidunique = $pdo->prepare("SELECT COUNT(product_id) AS productidunique FROM customer_cart WHERE user_name = :user");
            $productidunique->execute(array(':user' => $_SESSION['u_name']));
            $fetch_unique_of_product_id = $productidunique->fetch(PDO::FETCH_ASSOC);
            echo '<div class="col-md-12"><a href="cart_item.php" style="color:black;margin-left:90rem;font-size:20px;";><i class="fa fa-cart-plus"></i>Cart('.$fetch_unique_of_product_id['productidunique'].')</a></div>';
            }
            ?>
            <h3 style="position:absolute;top:6%;left:2rem;";>Welcome :  <?php echo $_SESSION['u_name'] ?></h3>
            <form method = "post" action="login.php">
                             <button style="position:absolute;top:1rem;left:95%"type="submit" class ="btn btn-danger" name="logout"> Log Out</button>
                          </form>
    </nav>
            <div class="active-cyan-3 active-cyan-4 mt-4" style="margin-left:35%;">
            <form class="form-inline" action="search_sport.php" method="post">
                <input class="form-control" type="text" placeholder="Search" name="value_field" required="required">
                <button style="margin-left:25%;" class="btn btn-warning btn-rounded btn-outline-success btn-xl ml-4 mr-0" type="submit" name="search">Search</button>
            </form>
        </div>

<div class="container ml-2" style="max-width: 200%;">
    <div class="row text-center pl-1 ml-4">
        <?php
            $product = $pdo->prepare("SELECT * FROM sport_acc");
            $product->execute();
            while($fetch_sports_info = $product->fetch(PDO::FETCH_ASSOC))
            {
                sports_info($fetch_sports_info['product_name'],$fetch_sports_info['actual_price'],$fetch_sports_info['price'],$fetch_sports_info['product_image'],$fetch_sports_info['Quantity'],$fetch_sports_info['product_id']);
            }
        ?>
    </div>
</div>


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>