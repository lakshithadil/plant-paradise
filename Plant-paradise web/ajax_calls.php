<?php
session_start();

if(isset($_POST['action']) && $_POST['action'] == 'update-qty')
{
    $sessionItem = $_POST['itemID'];
    $sessionItemQty = $_POST['qty'];
    $productSessionPrice = $_SESSION['cart_items'][$sessionItem]['total_price'];

    $_SESSION['cart_items'][$sessionItem]['qty'] = $sessionItemQty;
    $_SESSION['cart_items'][$sessionItem]['total_price'] = $sessionItemQty * $productSessionPrice;
    
    echo json_encode(['msg' => 'success']);
    exit();
}

if(isset($_POST['action']) && $_POST['action'] == 'empty')
{
    unset($_SESSION['cart_items']);
    echo json_encode(['msg' => 'success']);
    exit();
}