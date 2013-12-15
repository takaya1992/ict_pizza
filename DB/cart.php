<?php
require_once './Config/config.php';
cartInit();


function cartInit() {
	if (!array_key_exists('Cart', $_SESSION)) {
		$_SESSION['Cart'] = array();
	}
}


/**
 * addCartItem($product, $quantity)
 * 
 * カートにアイテムを追加する
 */
function addCartItem($product, $quantity) {
	$index = getCartItemIndex($product['id'], $product['specification']['size_id']);
	if ($index === false) {
		// *[1]
		$product['quantity'] = $quantity;
		array_push($_SESSION['Cart'], $product);
		return;
	}
	$_SESSION['Cart'][$index]['quantity'] += $quantity;
	return;
}


/**
 * getCartItemIndex($product_id, $size_id)
 * 
 * カートのアイテムのインデックスを取得する。
 * 指定の商品がカートになかった場合、falseを返す
 */
function getCartItemIndex($product_id, $size_id) {
	$i = 0;
	foreach ($_SESSION['Cart'] as $cart) {
		if ($cart['id'] == $product_id && $cart['specification']['size_id'] == $size_id) {
			return $i;
		}
		$i++;
	}
	return false;
}

function getCartTotalAmount() {
	$amount = 0;
	foreach ($_SESSION['Cart'] as $cart) {
		$amount += $cart['specification']['price'] * $cart['quantity'];
	}
	return $amount;
}

/*
 * [1]
 * 比較演算子の説明。"=="と"==="の違いとか説明できるといいかも
 * 
 */
