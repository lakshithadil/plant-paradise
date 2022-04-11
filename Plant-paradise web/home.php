<?php 
    session_start();
    require_once('./inc/config.php');    

    $sql = "SELECT p.*,pdi.img from products p
                    INNER JOIN product_images pdi ON pdi.product_id = p.id
                    WHERE pdi.is_featured = 1";
    $handle = $db->prepare($sql);
    $handle->execute();
    $getAllProducts = $handle->fetchAll(PDO::FETCH_ASSOC);

    
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="home.css">
  <script src="naviBarSlideDown.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <style>
   
  </style>

</head>
<body>

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

<!-- Carousel -->
<div id="demo" class="carousel slide" data-bs-ride="carousel">

  <!-- Indicators/dots -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
  </div>
  
  <!-- The slideshow/carousel -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="slide show images/slider-1.jpg" alt="Los Angeles" class="d-block" style="width:100%">
      <div class="carousel-caption" >
        <P id="captn">SALE UP TO 25% OFF</P>
        <p class="display-1"><b>Plant <i>made easy</i></b></p>
        <button type="button" class="btn btn-outline-success" id="btn" onclick="relocate_shop()">Shop indoor</button>&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" class="btn btn-outline-success" id="btn"onclick="relocate_shop()">Shop outdoor</button>
      </div>
    </div>
    <div class="carousel-item">
      <img src="slide show images/slider-2.jpg" alt="Chicago" class="d-block" style="width:100%">
      <div class="carousel-caption">
        <P  id="captn">SALE UP TO 25% OFF</P>
        <p class="display-1"><b>Make People <i>merry</i></b></p>
        <button type="button" class="btn btn-outline-success" id="btn" onclick="relocate_shop()"> Shop indoor</button>&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" class="btn btn-outline-success" id="btn" onclick="relocate_shop()">Shop outdoor</button>
      </div> 
    </div>
    <div class="carousel-item">
      <img src="slide show images/slider-3.jpg" alt="New York" class="d-block" style="width:100%">
      <div class="carousel-caption">
        <P  id="captn">SALE UP TO 25% OFF</P>
        <p class="display-1"><b>Gifts We <i>Love</i></b></p>
        <button type="button" class="btn btn-outline-success" id="btn" onclick="relocate_shop()">Shop indoor</button>&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" class="btn btn-outline-success" id="btn" onclick="relocate_shop()">Shop outdoor</button>
      </div>  
    </div>
  </div>
</div>
<div class="container-fluid text-center" id="body">    
  
  <div class="row">
    
    <div class="col-sm-4">
      <div class="card bg-dark text-black" style="">
      <img src="images/banner-10-4.jpg" class="card-img" alt="banner-img1">
      <div class="card-img-overlay" id="cardcap">
        <h5 class="card-title">New Arrivals</h5><br>
        <button type="button" class="btn btn-outline-success" id="btns" onclick="relocate_shop()">Shop now</button>
      </div>
    </div>
  </div>
    <div class="col-sm-4">
      <div class="card bg-dark text-black" id="cardmid">
      <img src="images/banner-10-5.jpg" class="card-img" alt="banner-img2" >
      <div class="card-img-overlay" id="cardcapmid">
        <h5 class="card-title">Gift Green</h5><br>
        <button type="button" class="btn btn-outline-success" id="btns" onclick="relocate_shop()">Shop now</button>
      </div>
    </div>
  </div>
    <div class="col-sm-4">
      <div class="card bg-dark text-black">
      <img src="images/banner-10-6.jpg" class="card-img" alt="banner-img3">
      <div class="card-img-overlay" id="cardcap">
        <h5 class="card-title">Home Grown</h5><br>
        <button type="button" class="btn btn-outline-success" id="btns"onclick="relocate_shop()">Shop now</button>
      </div>
    </div>
  </div>
  </div>
  
    
    
  </div>
</div>



<div class="container-fluid mt-3" style="margin-top: -17.5% !important;position:relative;z-index:-1;background-color: #FEFDF5;height:auto;padding-top: 20%;color: #3132329a;padding-bottom: 2%;">
  <div class="row">
    <div class="col-sm-2"><img src="images/img-4.png" width="100%"></div>
    <div class="col-sm-10" >
      <div class="container-fluid mt-3">
        <div class="row"><h1>Decorate your home with plants</h1>
          <p>Praesent egestas tristique nibh. Sed mollis, eros et ultrices tempus, mauris ipsum aliquam libero, non adipiscing dolor urna a orci. Fusce convallis metus id felis luctus adipiscing. Integer tincidunt. Etiam imperdiet imperdiet orci</p>
        </div><br>
        <div class="row">
          <div class="col-sm-4"><img src="images/quality.png" width="15%"><b> Unbeatable quality</b><br>Greater productivity and relaxation</div>
          <div class="col-sm-4"><img src="images/deliver.png" width="15%"><b> Delivery to your door</b><br>Better mental wellbeing and happiness</div>
          <div class="col-sm-4"><img src="images/plant.png" width="15%"><b> Bring nature into your life</b><br> Greater productivity and relaxation</div>
        </div>
      </div>

    </div>
  </div>
</div>
<br>
<div class="container-fluid mt-3 text-center">
  <div class="row">
    <div class="col-sm-12"><button type="button" class="btn btn-outline-success" id="btns">Top Rating</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <button type="button" class="btn btn-outline-success" id="btns">Best Selling</button></div>
    </div>
  <div class="row"></div>
  <div class="row"></div>
</div>


<div class="container-fluid mt-3">
    <div class="row">
    
      <?php
        foreach($getAllProducts as $product)
        {
            $imgUrl = PRODUCT_IMG_URL.str_replace(' ','-',strtolower($product['product_name']))."/".$product['img'];
        ?>
            <div class="col-md-3  mt-2" style="padding:3%;">
                <div class="card" style="border:1px solid #67AD7E;">
                     <a href="single-product.php?product=<?php echo $product['id']?>">
                        <img class="card-img-top" src="<?php echo $imgUrl ?>" alt="<?php echo $product['product_name'] ?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            
                            <a class="link-secondary" style="text-decoration:none;"  href="single-product.php?product=<?php echo $product['id'] ?>">
                                <?php echo $product['product_name']; ?>
                            </a>
                           
                        </h5>
                        <strong>Rs. <?php echo $product['price']?></strong>

                        <p class="card-t">
                            <?php echo substr($product['short_description'],0,50) ?>'...
                        </p>
                        <p class="card-text">
                            <a href="single-product.php?product=<?php echo $product['id']?>" class="btn btn-outline-success" id="btns">
                            &nbsp;&nbsp;View&nbsp;&nbsp;
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        <?php 
        }
        ?>
    
    </div>
</div>



<div class="container-fluid mt-3 text-center">
  <div class="row">
    <div class="col-sm-12">
    <img src="images/icons8_plant_48px_1.png" width="80px">
      <button type="button" class="btn btn-outline-success" id="btns" onclick="relocate_shop()"> View more</button>
    </div>
  </div>
  <div class="row" id="testi">
  <div class="col-sm"><i>Very happy with plant paradise; plants arrived in excellent condition,were healthy looking with lot of new growth and are thriving!</i><br><br><h4><small>Nimal jayasiri</small></h4>
</div>

  </div>
  <br>
  <div class="row">
  <div class="col-sm-6"><img src="images/img-5.jpg" width="100%"></div>
  <div class="col-sm-6"><div class="display-4" style="margin-top:10%;color: #3132329a;">Plants for offices</div><br><br>Plants not only bring varying rich shades of green to the workplace, they also offer the visually-meditative experience that, ultimately, leads to happier and healthier employees that are more productive. Providing plants for the office offers both customers and colleagues alike a visually enhanced perception of your space. An office teeming with vibrant greenery will also convey a positive brand image to visitors.<br><br><button type="button" class="btn btn-outline-success" id="btns">Shop now</button></div>
  
  </div>
  <br>
  <div class="row">
  <div class="col-sm-6 order-sm-2"><img src="images/img-6.jpg" width="100%"></div>
  <div class="col-sm-6 order-sm-1"><div class="display-4" style="margin-top:10%;color: #3132329a;">Sets for all styles</div><br><br>Indoor plants decoration makes your living space more comfortable, breathable, and luxurious. Arrange the tallest plants in the back, the medium-sized plants in the center and the lowest growing plants in the front to create a foreground, middle-ground and a background in your garden.<br><br><button type="button" class="btn btn-outline-success" id="btns">Shop now</button></div>
  </div>
</div>

<br><br><br>











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
     <div><img src="logo images/logo-green.png"  height="100%" width="100%"></div> 
     <br>
     <div class="row" id="footersocialmedia">
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
</body>
</html>