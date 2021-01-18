<?php
    session_start();
    require_once "header.php";
    $added_item=0;

    
    if(isset($_POST['logout'])){
        header("Location: login.php");
    }
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

                    $second_query = $pdo->prepare("INSERT INTO customer_cart (product_id, product_name,actual_price, price, product_image, user_name) 
                                    VALUES (:product_id, :product_name,:actual_price, :price, :product_image, :user) ");
                    $second_query -> execute(array(':product_id' => $fetch_first_query['product_id'],
                                                ':product_name' => $fetch_first_query['product_name'], 
                                                ':actual_price' => $fetch_first_query['actual_price'],
                                                ':price' => $fetch_first_query['price'],
                                                ':product_image' => $fetch_first_query['product_image'],
                                                ':user' => $_SESSION['u_name']));  

                    $third_query = $pdo->prepare("UPDATE sport_acc SET Quantity = Quantity - 1 WHERE product_id = :product_id");
                    $third_query -> execute(array(':product_id' => $_POST['product_id']));
                    $added_item=1;
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
<div class="container ml-2" style="max-width: 100%;">
    <nav class="navbar bg-success navbar-default fixed-top">
        <a href="homepage.php" class ="navbar-brand">
            <h3 class="px-2">
                <i class="fas fa-shopping-basket"></i><span class ="text-dark ml-2">Shopping Cart</span>
            </h3>
        </a>
        <?php
            if(isset($_SESSION['u_name'])){
                echo '<h3 class="text-dark">Welcome :'.$_SESSION['u_name'].'</h3>';
            }
        ?>
        
        <form class="form-inline" action="search_sport.php" method="post">
                <input class="form-control" type="text" placeholder="Search" name="value_field" required="required">
                <button style="margin-left:25%;" class="btn btn-warning btn-rounded btn-outline-success btn-xl ml-4 mr-0" type="submit" name="search">Search</button>
        </form>
        <?php
            if(isset($_SESSION['u_name']))
            {
                $productidunique = $pdo->prepare("SELECT COUNT(product_id) AS productidunique FROM customer_cart WHERE user_name = :user");
                $productidunique->execute(array(':user' => $_SESSION['u_name']));
                $fetch_unique_of_product_id = $productidunique->fetch(PDO::FETCH_ASSOC);
                    echo '<h4 class="text-warning">
                            <a href="cart_item.php" class = "nav-link"><i class = "fa fa-shopping-cart text-warning"></i><span class="text-white ml-2">Cart
                            <span class="text-success">('.$fetch_unique_of_product_id['productidunique'].')</span>
                            </a>
                        </h4>';
                    
                    echo '<form method = "post" action="login.php">
                             <button type="submit" class ="btn btn-danger" name="logout"> Log Out</button>
                          </form>';
            }
        ?>
    </nav> 
    <div class="row text-center pl-1 ml-1">
    <h3 class = "text-info" style="margin-top:5%;">
    <?php if($added_item == 1)
        {
            echo '<script>swal("Good job!","Item Successfully Added to the cart","success")</script>';
        }
    ?>
    </h3>
        <?php
            if(isset($_POST['search']))
            {
                $value_filter = $_POST['value_field'];

                $sql = "SELECT count(*) FROM sport_acc WHERE (product_name LIKE '%$value_filter%' AND Quantity > 0)";
                $res = $pdo->query($sql);
                $count = $res->fetchColumn();

                echo '<div class="row text-center mt-2">
                    <h3 class="text-dark"><b>There are <span class="text-success">'.$count.'</span> matching record.</b></h3>
                    </div>';

                $search = $pdo->prepare("SELECT * FROM sport_acc WHERE (product_name LIKE '%$value_filter%' AND Quantity > 0)");
                $search->execute();
                while($row = $search->fetch(PDO::FETCH_ASSOC))
                {
                    sports_info($row['product_name'],$row['actual_price'],$row['price'],$row['product_image'],$row['Quantity'],$row['product_id']);
                }
              
            }
        ?>
    </div>
</div>
</body>
</html>
    
