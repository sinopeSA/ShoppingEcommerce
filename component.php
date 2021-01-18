<?php
require_once "configuration.php";
function sports_info($product_name,$actual_price,$Price,$product_img,$Quantity,$product_id){
    $element='
    <div class="col-xs-12 col-sm-7 col-md-2 col-xl-1  my-3 mx-3 pr-4" style="width: 15rem; height:30rem;background:#fff" id="row">
        <form method="post">
            <div class="card-shadow1">
                <div class="card-shadow my-2">
                    <img src='."$product_img".' alt="image1" class="img-fluid card-img-top rounded mr-3">
                </div>
                <div class="card-body pt-0 ml-0"> 
                    <p class="card-title ml-0"><b>'."$product_name".'</b></p>   
                    <h4>
                        <span class="text-success">₹ '."$Price".'</span>
                        <small><s>₹ '."$actual_price".'</s>'."(".$Quantity.")".'</small>
                    </h4>
                    <h6>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="far fa-star"></i>
                    </h6>
                    <button type="submit" class="btn-md btn btn-warning mt-4" name="add_to_cart" style="border=2px solid #000;">Add to cart <i class="fa fa-cart-plus pl-2"></i></button>
                    <input type="hidden" name="product_id" value="'.$product_id.'">
                </div>
            </div>
        </form>
        </div>
    ';
    echo $element;
}

function cart_element($product_img,$product_name,$Price,$actual_price,$products_id){
    $discount = (int) ((100 * ($actual_price - $Price))/($actual_price));
    $element = '
    <form action="cart_item.php" method="post" class = "cart-items">
    <div class="border-rounded mt-3">
        <div class="row bg-white">
            <div class="col-md-3">
                <img style="height: 150px;" src="'.$product_img.'" alt="" class = "img-fluid mt-2 mb-2 ml-4 rounded">
            </div>
            <div class="col-md-6">
                <h5 class="pt-2">'.$product_name.'</h5>
                <h4>
                    <span class="text-success">₹ '."$Price".'</span>
                    <code class="text-secondary"><s>₹'."$actual_price".'</s></code>
                    <span class = "text-success">'.$discount.'% off</span>
                </h4>
                <button class="btn btn-danger mx-3 mt-3" name="remove_item">Remove</button>
                <input type="hidden" name="product_id_remove" value="'.$products_id.'">
                
            </div>
            <!-- <div class="col-md-3">

            </div> -->
        </div>
    </div>
</form>
    ';
    echo $element;
}
?>
