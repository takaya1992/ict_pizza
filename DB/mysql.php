<?php
require_once './Config/config.php';


/*
====================
 メモ
-------------------- 
getDBConnection() を呼び出すだけで
DBとの接続を取得できるようにする。
  new PDO(...);
を繰り返し呼ぶといくつも接続を作って
しまう(DB側、プログラム側の負荷となる)ので、
  static $db;
とし、getDBConnection()関数内で永続的に値を保持するようにする。
合わせて、変数のスコープの話ができるといい。

オブジェクト指向や例外処理に関しては、
今回は"おまじない"ということで流しとくのがいいかと。
====================
*/

/**
 * getConnection()
 * 
 * DBとの接続を取得する。
 * 
 * ex)
 * $dbh = $getConnection();
 */
function getDBConnection() {
	static $dbh;
	if (isset($dbh)) {
		return $dbh;
	}
	try {
		$dsn = 'mysql:dbname='. DB_NAME .';host='. DB_HOST .';charset=utf8';
		$dbh = new PDO($dsn, DB_USER, DB_PASS);
	} catch (PDOException $e) {
		echo 'Connection Error:'. $e->getMessage();
		exit;
	}
	return $dbh;
}


/**
 * getProductById($id)
 * 
 * 商品を商品IDで検索し取得する。
 */
function getProductById($id) {
	$dbh = getDBConnection();
	
	$sth = $dbh->prepare('SELECT * FROM products WHERE id = ?;');
	$sth->execute(array($id));
	return $sth->fetch(PDO::FETCH_ASSOC);
}

/**
 * getAllProducts()
 * 
 * すべての商品を取得する。
 */
function getAllProducts() {
	$dbh = getDBConnection();

	$sth = $dbh->prepare('SELECT * FROM products;');
	$sth->execute();
	return $sth->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * getAllProductsWithSpecifications()
 * 
 * すべての商品とそれに紐ついた明細情報を取得する。
 */
function getAllProductsWithSpecifications() {
	$products = getAllProducts();
	foreach ($products as &$product) {
		$product['specifications'] = getProductSpecificationsByProductId($product['id']);
	}
	unset($product);
	return $products;
}

/**
 * getProductWithSpecificationsById($id)
 * 
 * 商品とそれに紐ついた明細情報を商品IDで検索し取得する。
 */
function getProductWithSpecificationsById($id) {
	$product = getProductById($id);
	if (!$product) {
		return false;
	}
	$product['specifications'] = getProductSpecificationsByProductId($product['id']);
	return $product;
}

/**
 * getProductSpecificationsByProductId($id)
 * 
 * 商品明細情報を商品IDで検索し取得する。
 */
function getProductSpecificationsByProductId($id) {
	$dbh = getDBConnection();
	
	$sth = $dbh->prepare('SELECT product_specifications.* FROM product_specifications JOIN product_sizes ON product_specifications.size_id = product_sizes.id WHERE product_id = ? ORDER BY product_sizes.order ASC;');
	$sth->execute(array($id));
	$specifications = $sth->fetchAll(PDO::FETCH_ASSOC);
	foreach ($specifications as &$specification) {
		$specification['size'] = getSizeById($specification['size_id']);
	}
	unset($specification);
	return $specifications;
}



/**
 * getSizeById($id)
 * 
 * 商品サイズをサイズIDで検索し取得する。
 */
function getSizeById($id) {
	$dbh = getDBConnection();
	
	$sth = $dbh->prepare('SELECT * FROM product_sizes WHERE id = ?');
	$sth->execute(array($id));
	return $sth->fetch(PDO::FETCH_ASSOC);
}

/**
 * getSpecificationByProductIdAndSizeId($product_id, $size_id)
 * 
 * 商品情報と明細情報を商品IDとサイズIDで検索し、取得する。
 */
function getSpecificationByProductIdAndSizeId($product_id, $size_id) {
	$dbh = getDBConnection();
	
	$product = getProductById($product_id);
	if (!$product) {
		return false;
	}
	
	$sth = $dbh->prepare('SELECT * FROM product_specifications WHERE product_id = ? AND size_id = ?');
	$sth->execute(array($product_id, $size_id));
	$specification = $sth->fetch(PDO::FETCH_ASSOC);
	if (!$specification) {
		return false;
	}
	$specification['size'] = getSizeById($specification['size_id']);
	$product['specification'] = $specification;
	return $product;
}




/*
 *   foreach($array as &$value) {
 *       ...
 *   }
 * とした場合、foreachを抜けても
 * $value に $array の最後の要素のポインタが
 * 保持され続けてしまうため、unset($value) で
 * 参照を解除する。
 */
