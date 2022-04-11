<?php 
    session_start();

     if(!isset($_SESSION['confirm_order']) || empty($_SESSION['confirm_order']))
     {
         header('location:home.php');
         exit();
     }

    require_once('./inc/config.php');    
    
?>
<div class="row">
    <div class="col-md-12">
        <h1>Thank you!</h1>
        <p>
            Your order has been placed.
            <?php unset($_SESSION['confirm_order']);?>
        </p>
    </div>
</div>
   