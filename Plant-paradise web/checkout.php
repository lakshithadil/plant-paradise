<?php 
    session_start();

    if(!isset($_SESSION['cart_items']) || empty($_SESSION['cart_items']))
    {
        header('location:index.php');
        exit();
    }

    require_once('./inc/config.php');    
    
    $cartItemCount = count($_SESSION['cart_items']);

    //pre($_SESSION);

    if(isset($_POST['submit']))
    {
        if(isset($_POST['first_name'],$_POST['last_name'],$_POST['email'],$_POST['address'],$_POST['country'],$_POST['state'],$_POST['zipcode']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['address']) && !empty($_POST['country']) && !empty($_POST['state']) && !empty($_POST['zipcode']))
        {
           $firstName = $_POST['first_name'];

           if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) == false)
           {
                 $errorMsg[] = 'Please enter valid email address';
           }
           else
           {
               //validate_input is a custom function
               //you can find it in helpers.php file
                $firstName  = validate_input($_POST['first_name']);
                $lastName   = validate_input($_POST['last_name']);
                $email      = validate_input($_POST['email']);
                $address    = validate_input($_POST['address']);
                $address2   = (!empty($_POST['address'])?validate_input($_POST['address']):'');
                $country    = validate_input($_POST['country']);
                $state      = validate_input($_POST['state']); 
                $zipcode    = validate_input($_POST['zipcode']);

                $sql = 'insert into orders (first_name, last_name, email, address, address2, country, state, zipcode, order_status,created_at, updated_at) values (:fname, :lname, :email, :address, :address2, :country, :state, :zipcode, :order_status,:created_at, :updated_at)';
                $statement = $db->prepare($sql);
                $params = [
                    'fname' => $firstName,
                    'lname' => $lastName,
                    'email' => $email,
                    'address' => $address,
                    'address2' => $address2,
                    'country' => $country,
                    'state' => $state,
                    'zipcode' => $zipcode,
                    'order_status' => 'confirmed',
                    'created_at'=> date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ];

                $statement->execute($params);
                if($statement->rowCount() == 1)
                {
                    
                    $getOrderID = $db->lastInsertId();

                    if(isset($_SESSION['cart_items']) || !empty($_SESSION['cart_items']))
                    {
                        $sqlDetails = 'insert into order_details (order_id, product_id, product_name, product_price, qty, total_price) values(:order_id,:product_id,:product_name,:product_price,:qty,:total_price)';
                        $orderDetailStmt = $db->prepare($sqlDetails);

                        $totalPrice = 0;
                        foreach($_SESSION['cart_items'] as $item)
                        {
                            $totalPrice+=$item['total_price'];

                            $paramOrderDetails = [
                                'order_id' =>  $getOrderID,
                                'product_id' =>  $item['product_id'],
                                'product_name' =>  $item['product_name'],
                                'product_price' =>  $item['product_price'],
                                'qty' =>  $item['qty'],
                                'total_price' =>  $item['total_price']
                            ];

                            $orderDetailStmt->execute($paramOrderDetails);
                        }
                        
                        $updateSql = 'update orders set total_price = :total where id = :id';

                        $rs = $db->prepare($updateSql);
                        $prepareUpdate = [
                            'total' => $totalPrice,
                            'id' =>$getOrderID
                        ];

                        $rs->execute($prepareUpdate);
                        
                        unset($_SESSION['cart_items']);
                        $_SESSION['confirm_order'] = true;
                        header('location:thank-you.php');
                        exit();
                    }
                }
                else
                {
                    $errorMsg[] = 'Unable to save your order. Please try again';
                }
           }
        }
        else
        {
            $errorMsg = [];

            if(!isset($_POST['first_name']) || empty($_POST['first_name']))
            {
                $errorMsg[] = 'First name is required';
            }
            else
            {
                $fnameValue = $_POST['first_name'];
            }

            if(!isset($_POST['last_name']) || empty($_POST['last_name']))
            {
                $errorMsg[] = 'Last name is required';
            }
            else
            {
                $lnameValue = $_POST['last_name'];
            }

            if(!isset($_POST['email']) || empty($_POST['email']))
            {
                $errorMsg[] = 'Email is required';
            }
            else
            {
                $emailValue = $_POST['email'];
            }

            if(!isset($_POST['address']) || empty($_POST['address']))
            {
                $errorMsg[] = 'Address is required';
            }
            else
            {
                $addressValue = $_POST['address'];
            }

            if(!isset($_POST['country']) || empty($_POST['country']))
            {
                $errorMsg[] = 'Country is required';
            }
            else
            {
                $countryValue = $_POST['country'];
            }

            if(!isset($_POST['state']) || empty($_POST['state']))
            {
                $errorMsg[] = 'State is required';
            }
            else
            {
                $stateValue = $_POST['state'];
            }

            if(!isset($_POST['zipcode']) || empty($_POST['zipcode']))
            {
                $errorMsg[] = 'Zipcode is required';
            }
            else
            {
                $zipCodeValue = $_POST['zipcode'];
            }


            if(isset($_POST['address2']) || !empty($_POST['address2']))
            {
                $address2Value = $_POST['address2'];
            }

        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>check out</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
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
  <h1 class="display-3" style="margin-top:10%;">CHECK OUT</h1> 
</div>
<br><br><br>
<div class="container-fluid text-center" id="headfontsize">
   <div class="row">
    <div class="col-sm-12">Place your order here</div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <img src="images/spimg.png" width="30%">
    </div>
  </div>
</div>











<div class="container-fluid">
<div class="row mt-3">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill"><?php echo $cartItemCount;?></span>
          </h4>
          <ul class="list-group mb-3">
            <?php
                $total = 0;
                foreach($_SESSION['cart_items'] as $cartItem)
                {
                    $total+=$cartItem['total_price'];
                ?>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0"><?php echo $cartItem['product_name'] ?></h6>
                            <small class="text-muted">Quantity: <?php echo $cartItem['qty'] ?> X Price: <?php echo $cartItem['product_price'] ?></small>
                        </div>
                        <span class="text-muted">Rs.<?php echo $cartItem['total_price'] ?></span>
                    </li>
            <?php
                }
            ?>
           
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (LKR)</span>
              <strong>Rs.<?php echo number_format($total,2);?></strong>
            </li>
          </ul>
        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Billing address</h4>
          <?php 
            if(isset($errorMsg) && count($errorMsg) > 0)
            {
                foreach($errorMsg as $error)
                {
                    echo '<div class="alert alert-danger">'.$error.'</div>';
                }
            }
          ?>
          <form class="needs-validation" method="POST">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">First name</label>
                <input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" value="<?php echo (isset($fnameValue) && !empty($fnameValue)) ? $fnameValue:'' ?>" >
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Last name</label>
                <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" value="<?php echo (isset($lnameValue) && !empty($lnameValue)) ? $lnameValue:'' ?>" >
              </div>
            </div>

            <div class="mb-3">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" value="<?php echo (isset($emailValue) && !empty($emailValue)) ? $emailValue:'' ?>">
            </div>

            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" value="<?php echo (isset($addressValue) && !empty($addressValue)) ? $addressValue:'' ?>">
            </div>

            <div class="mb-3">
              <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" name="address2" placeholder="Apartment or suite" value="<?php echo (isset($address2Value) && !empty($address2Value)) ? $address2Value:'' ?>">
            </div>

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">Country</label>
                <select class="custom-select d-block w-100" name="country" id="country" >
                  <option value="">Choose...</option>
                  <option value="Sri Lanka" >Sri Lanka</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label for="state">State</label>
                <select class="custom-select d-block w-100" name="state" id="state" >
                  <option value="">Choose...</option>
                  <option value="Colombo">Colombo</option>
                  <option value="Kandy">Kandy</option>
                  <option value="Kurunegala">Kurunegala</option>
                </select>
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="zip" name="zipcode" placeholder="" value="<?php echo (isset($zipCodeValue) && !empty($zipCodeValue)) ? $zipCodeValue:'' ?>" >
              </div>
            </div>
            <hr class="mb-4">

            <h4 class="mb-3">Payment</h4>

            <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input id="cashOnDelivery" name="cashOnDelivery" type="radio" class="custom-control-input" checked="" >
                <label class="custom-control-label" for="cashOnDelivery">Cash on Delivery</label>
              </div>
            </div>
           
            <hr class="mb-4">
            <button class="btn btn-success btn-lg btn-block" type="submit" name="submit" value="submit">Continue to checkout</button>
          </form>
        </div>
      </div>
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