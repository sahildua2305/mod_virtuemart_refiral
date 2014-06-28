<?php
/*
 * Refiral
 * @package mod_virtuemart_refiral
 * @author: Refiral (support@refiral.com)
 * @copyright (C) 2014- Refiral
 * @license GNU/GPL, see LICENSE.txt
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$apiKey = $params->get('apiKey');
$campaign_on = $params->get('campaign_on');
session_start();

echo '<script>';
echo 'var apiKey = "'.$apiKey.'";';
if($campaign_on == '0' || $_POST['task'] == 'confirm'){
	echo 'var showButton = false;';
}
else{
	echo 'var showButton = true;';
}
echo '</script>';
echo '<script src="//rfer.co/api/v0/js/all.js"></script>';

if($_POST['task'] == 'confirm'){
	$customer_name = $_SESSION['customer_name'];
	$customer_email = $_SESSION['customer_email'];
	$couponCode = $_SESSION['couponCode'];
	$subTotal = $_SESSION['subTotal'];
	$grandTotal = $_SESSION['grandTotal'];
	
	$refiral_cart = $_SESSION['refiral_cart'];
	$refiral_cart_items = array();
	foreach($refiral_cart as $product){
		$refiral_cart_items[] = array('product_id' => $product->virtuemart_product_id,
									'quantity' 	   => $product->quantity,
									'name'         => $product->product_name,
									'price'        => $product->product_price);
	}
	$refiral_cart_info = json_encode($refiral_cart_items);
	
	echo "<script>invoiceRefiral('$subTotal', '$grandTotal', '$couponCode', '$refiral_cart_info', '$customer_name', '$customer_email');</script>";
}

