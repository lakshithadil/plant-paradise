<?php 
    session_start();
    require_once('./inc/config.php');    
    require_once('./inc/helpers.php'); 
    
    if(isset($_GET['product']) && !empty($_GET['product']) && is_numeric($_GET['product']))
    {
        $sql = "SELECT p.*,pdi.img from products p
            INNER JOIN product_images pdi ON pdi.product_id = p.id WHERE pdi.is_featured =:featured AND p.id =:productID";
        $handle = $db->prepare($sql);
        $params = [
                ':featured'=>1,
                ':productID' =>$_GET['product'],
            ];
        $handle->execute($params);
        if($handle->rowCount() == 1 )
        {
            $getProductData = $handle->fetch(PDO::FETCH_ASSOC);
            $imgUrl = PRODUCT_IMG_URL.str_replace(' ','-',strtolower($getProductData ['product_name']))."/".$getProductData ['img'];
        }
        else
        {
            $error = '404! No record found';
        }

    }
    else
    {
        $error = '404! No record found';
    }

    if(isset($_POST['add_to_cart']) && $_POST['add_to_cart'] == 'add to cart')
    {
        $productID = intval($_POST['product_id']);
        $productQty = intval($_POST['product_qty']);
        
        $sql = "SELECT p.*,pdi.img from products p
            INNER JOIN product_images pdi ON pdi.product_id = p.id WHERE pdi.is_featured =:featured AND p.id =:productID";

        $prepare = $db->prepare($sql);
        
        $params = [
                ':featured'=>1,
                ':productID' =>$productID,
            ];
        
        $prepare->execute($params);
        $fetchProduct = $prepare->fetch(PDO::FETCH_ASSOC);

        $calculateTotalPrice = number_format($productQty * $fetchProduct['price'],2);
        
        $cartArray = [
            'product_id' =>$productID,
            'qty' => $productQty,
            'product_name' =>$fetchProduct['product_name'],
            'product_price' => $fetchProduct['price'],
            'total_price' => $calculateTotalPrice,
            'product_img' =>$fetchProduct['img']
        ];
        
        if(isset($_SESSION['cart_items']) && !empty($_SESSION['cart_items']))
        {
            $productIDs = [];
            foreach($_SESSION['cart_items'] as $cartKey => $cartItem)
            {
                $productIDs[] = $cartItem['product_id'];
                if($cartItem['product_id'] == $productID)
                {
                    $_SESSION['cart_items'][$cartKey]['qty'] = $productQty;
                    $_SESSION['cart_items'][$cartKey]['total_price'] = $calculateTotalPrice;
                    break;
                }
            }

            if(!in_array($productID,$productIDs))
            {
                $_SESSION['cart_items'][]= $cartArray;
            }

            $successMsg = true;
            
        }
        else
        {
            $_SESSION['cart_items'][]= $cartArray;
            $successMsg = true;
        }

    }


?>

    

<!DOCTYPE html>
<html lang="en">
<head>
  <title>plant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="shop.css">
  <script src="naviBarSlideDown.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <style>
  
  </style>

</head>
<body onload="window.addEventListener('resize', setPanels); setPanels();">

<!-- navi bar top main -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark" id="navbarmain">
  <div class="container-fluid">
    <a class="navbar-brand" href="#" style="margin-right:-130px;"><img src="logo images/logo-green.png"  height="50%" width="50%"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
      <li class="nav-item">
          <a class="nav-link" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="shop.php">Shop</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">My cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact us.php">Contact us</a>
        </li> 
      </ul>
      <div class="nav-link">
      <a class="link-success" href="#" ><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentcolor" class="bi bi-person-fill" viewBox="0 0 16 16">
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
      </svg></a>
     </div>
     <div class="nav-link">
     <a style="text-decoration:none;" class="link-success" href="cart.php"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentcolor" class="bi bi-cart2" viewBox="0 0 16 16">
        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
      </svg>
      <?php 
                echo (isset($_SESSION['cart_items']) && count($_SESSION['cart_items'])) > 0 ? count($_SESSION['cart_items']):'';
            ?></a>
      </div>
    </div>
  </div>
</nav>

<!-- navi bar side down on scroll --> 
<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top" id="navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="#" style="margin-right:-130px;"><img src="logo images/logo-white.png"  height="50%" width="50%"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbarscroll">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbarscroll">
      <ul class="navbar-nav me-auto">
      <li class="nav-item">
          <a class="nav-link" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="shop.php">Shop</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">My cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact us.php">Contact us</a>
        </li> 
      </ul>
      <div class="nav-link">
      <a class="link-success" href="#" ><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentcolor" class="bi bi-person-fill" viewBox="0 0 16 16">
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
      </svg></a>
     </div>
     <div class="nav-link">
     <a style="text-decoration:none;" class="link-success" href="cart.php"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentcolor" class="bi bi-cart2" viewBox="0 0 16 16">
        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
      </svg>
      <?php 
                echo (isset($_SESSION['cart_items']) && count($_SESSION['cart_items'])) > 0 ? count($_SESSION['cart_items']):'';
            ?></a>
      </div>
    </div>
  </div>
</nav>



<div class="jumbotron text-center">
  <h1 class="display-3" style="margin-top:10%;">PLANT</h1> 
</div>


<?php if(isset($getProductData) && is_array($getProductData)){?>
        <?php if(isset($successMsg) && $successMsg == true){?>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible">
                         <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <img src="<?php echo $imgUrl ?>" class="rounded img-thumbnail mr-2" style="width:40px;"><?php echo $getProductData['product_name']?> is added to cart. <a href="cart.php" class="alert-link">View Cart</a>
                    </div>
                </div>
            </div>
         <?php }?>

<div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-5">
                <img src="<?php echo $imgUrl;?>" width="100%">
            </div>
            <div class="col-md-7">
                <h1><?php echo $getProductData['product_name']?></h1>
                <p><?php echo $getProductData['short_description']?></p>
                <h4>Rs. <?php echo $getProductData['price']?></h4>
                
                <form class="form-inline" method="POST">
                    <div class="form-group mb-2">
                        <input type="number" name="product_qty" id="productQty" class="form-control" placeholder="Quantity" min="1" max="1000" value="1">
                        <input type="hidden" name="product_id" value="<?php echo $getProductData['id']?>">
                    </div>
                    <div class="form-group mb-2 ml-2">
                        <button type="submit" class="btn btn-success" name="add_to_cart" value="add to cart">Add to Cart</button>
                    </div>
                </form>
                
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <?php echo $getProductData['full_description']?>
            </div>
        </div>

    <?php
    }
    ?>
</div>
<br><br>
      <div class="container-fluid bg-3 text-center text-white bg-dark" id="footerbody">    
  
  <div class="row">
    <div class="col-sm-3">
      <h5><b>ABOUT</b></h5><hr>
      
      <p>Nothing adds more beauty and comfort to our homes and offices than the lush flowers and foliage of indoor plants. Bedrooms, bathrooms, kitchens, cubicles… There really isn’t a space a houseplant can’t enliven. Just add light and water, and you’ve got a growing indoor oasis. Bringing plants into your home is aesthetically pleasing and – amazingly – plants can offer strong health benefits as well! </p>
    </div>

    <div class="col-sm-3"> 
      <h5><b>USEFUL LINKS</b></h5><hr>
      <p><a class="link-success" href="#" >Plant paradise</a></p>
      <p><a class="link-success" href="#" >Shop</a></p>
      <p><a class="link-success" href="#" >My cart</a></p>
      <p><a class="link-success" href="#" >Contact us</a></p>
    </div>
    
    <div class="col-sm-3">
      <h5><b>OUR SHOPS</b></h5><hr>
      <p>No:567/C,Ritz Tower,Colombo 08,Sri Lanka.</p>
      <p>No:567/C,Ritz Tower,Colombo 08,Sri Lanka.</p>
      <p>No:567/C,Ritz Tower,Colombo 08,Sri Lanka.</p>
    </div>

    <div class="col-sm-3">
      <h5><b>CONTACT US</b></h5><hr>
      <p>No:567/C,Ritz Tower,Colombo 08,Sri Lanka.</p>
      <p>Phone: 011-1234123</p>
      <p>Email: support@Plantparadise.com</p>
      <p>Opening Time</p>
      <p>8:00Am – 10:00Pm, Sunday Close</p>
     <div><img src="logo images/logo-green.png"  height="100%" width="100%" ></div> 
     <br>
     <div class="row" id ="footersocialmedia">
      <div class="col-sm"><a class="link-success" href="#"><i class="bi bi-facebook" style="font-size: 25px;"></i></a></div>
      <div class="col-sm"><a class="link-success" href="#"><i class="bi bi-youtube" style="font-size: 25px;"></i></a></div>
      <div class="col-sm"><a class="link-success" href="#"><i class="bi bi-instagram" style="font-size: 25px;"></i></a></div>
      <div class="col-sm"><a class="link-success" href="#"><i class="bi bi-whatsapp" style="font-size: 25px;"></i></a></div>
    </div>
    
    
    
    
    </div>
  </div>
</div>

<footer class="container-fluid text-center text-white bg-dark" id="footer">
  <p>Plantparadise.com<br>© 2022 All rights reserved | Designed by GROUP 5</p>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>    
<script src="assets/js/cart.js"></script>
</body>
</html>