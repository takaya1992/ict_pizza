<?php
/**
 * detail.php
 */
session_start();
require_once './Config/config.php';
require_once './DB/mysql.php';
require_once './DB/cart.php';

if (!array_key_exists('id', $_GET)) {
	print 'idを指定してください';
	exit;
}



if (!empty($_POST)) {
	// quantityの妥当性確認 - 1から5の間か
	if (!(1 <= $_POST['quantity'] && $_POST['quantity'] <= 5)) {
		print '個数が不正です。';
		exit;
	}
	
	$product = getSpecificationByProductIdAndSizeId($_GET['id'], $_POST['size']);
	if (!$product) {
		print 'IDまたはサイズが不正です。';
		exit;
	}
	
	// カートに追加する
	addCartItem($product, $_POST['quantity']);
	
	header('Location: index.php');
	exit;
}


$product = getProductWithSpecificationsById($_GET['id']);

if (!$product) {
	print 'idが見つかりませんでした';
	exit;
}


?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>電設ピザ</title>
    
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
    <style>
    </style>
  </head>

  <body>
    <div class="navbar navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">電設ピザ</a>
        </div>
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    <div class="container">
      <div class="row">
        <div class="col-xs-8">
          <div class="row">
            <div class="col-xs-8">
          	  <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><?php echo $product['name']; ?></h3>
                </div>
                <div class="panel-body">
                  <img src="images/dummy.jpg" class="img-responsive">
                  <table class="table">
                    <tr>
                    <?php foreach ($product['specifications'] as $specification): ?>
                      <th><?php echo $specification['size']['name']; ?></th>
                      <td><?php echo '¥'. number_format($specification['price']); ?></td>
                    <?php endforeach; ?>
                    </tr>
                  </table>
                  <p><?php echo $product['description']; ?></p>
                  <form class="form-inline" role="form" action="" method="post">
                  	<div class="form-group">
                      <label for="pizza-size">サイズ</label>
                      <select class="form-control input-sm" name="size">
                        <?php foreach($product['specifications'] as $specification) : ?>
                          <option value="<?php echo $specification['size']['id']; ?>"><?php echo $specification['size']['name']; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="pizza-quantity">個数</label>
                      <select class="form-control input-sm" name="quantity">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-default">買い物カゴに入れる</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div><!--/span-->

        <div class="col-xs-4" id="sidebar">
          <?php include './View/Parts/cart.php'; ?>
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; JEC-ICT 2013-2014</p>
      </footer>

    </div><!--/.container-->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  </body>
</html>