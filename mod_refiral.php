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

//Include the syndicate functions only once
require_once( dirname(__FILE__).'/helper.php' );
session_start();

$refiral_campaign = modRefiralHelper::startCampaign( $params );

if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();

if(!class_exists('VirtueMartCart')) require(JPATH_VM_SITE.DS.'helpers'.DS.'cart.php');
if(!class_exists('CouponHelper')) require(JPATH_VM_SITE.DS.'helpers'.DS.'coupon.php');
$cart = VirtueMartCart::getCart(false);
$data = $cart->prepareAjaxData();

$firstName = empty($cart->BT['first_name'])? '':$cart->BT['first_name'];
$lastName = empty($cart->BT['last_name'])? '':$cart->BT['last_name'];
$email = empty($cart->BT['email'])? '':$cart->BT['email'];

if($_POST['task'] == 'confirm'){
	$confirmed = 1;
}
else{
	$confirmed = 0;
	$_SESSION['refiral']['customer_name'] = $firstName." ".$lastName;
	$_SESSION['refiral']['customer_email'] = $email;
	$_SESSION['refiral']['couponCode'] = $cart->couponCode;
	$_SESSION['refiral']['grandTotal'] = preg_replace("/[^0-9.,]/", "", $data->billTotal);
	$_SESSION['refiral']['subTotal'] = '';
	$_SESSION['refiral']['refiral_cart'] = $cart->products;
}

require( JModuleHelper::getLayoutPath( 'mod_virtuemart_refiral' ) );