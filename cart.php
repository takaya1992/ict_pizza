<?php
session_start();
require_once './Config/config.php';
require_once './DB/mysql.php';
require_once './DB/cart.php';


if (!empty($_POST)) {
	if (array_key_exists('delete', $_POST)) {
		if ($_POST['delete'] == 'all') {
			$_SESSION['Cart'] = array();
        } else {
            if (0 <= $_POST['delete'] && $_POST['delete'] < count($_SESSION['Cart'])) {
                array_splice($_SESSION['Cart'], $_POST['delete'], 1);
            }
        }
    }
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
      <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
    <style>
    </style>
  </head>

  <body>
    <div class="navbar navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="./index.php">電設ピザ</a>
        </div>
      </div><!-- /.container -->
    </div><!-- /.navbar -->

    <div class="container">
      <div class="row">
        <div class="col-xs-8">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">買い物カゴ</h3>
            </div>
            <div class="panel-body">
              <?php if (is_array($_SESSION['Cart']) && count($_SESSION['Cart']) == 0): ?>
                <p>現在、カートに商品がありません。</p>
              <?php else: ?>
              	<form action="" method="post">
                <table class="table">
                  <tr>
                    <th>商品名</th>
                    <th>サイズ</th>
                    <th>単価</th>
                    <th>個数</th>
                    <th>小計</th>
                    <th>削除</th>
                  </tr>
                  <?php foreach ($_SESSION['Cart'] as $key => $cart): ?>
                    <tr>
                      <td><?php echo $cart['name']; ?></td>
                      <td><?php echo $cart['specification']['size']['name']; ?></td>
                      <td style="text-align: right;"><?php echo '¥'. number_format($cart['specification']['price']); ?></td>
                      <td style="text-align: right;"><?php echo $cart['quantity']; ?></td>
                      <td style="text-align: right;"><?php echo '¥'. number_format($cart['specification']['price'] * $cart['quantity']); ?></td>
                      <td><button type="submit" class="btn btn-default" name="delete" value="<?php echo $key; ?>">削除</button></td>
                    </tr>
                  <?php endforeach; ?>
                  <tr>
                    <th colspan="4">合計</th>
                    <td style="text-align: right;"><?php echo '¥'. number_format(getCartTotalAmount()); ?></td>
                    <td></td>
                  </tr>
                </table>
                
                <button type="submit" class="btn btn-danger" name="delete" value="all">カート内一括削除</button> 
                </form>
              <?php endif; ?>
            </div>
          </div><!--/.panel-->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">注文情報</h3>
            </div>
            <div class="panel-body">
              <p>以上の内容でよろしければ配達先情報をご入力ください。</p>
              <form role="form" action="order.php" method="post">
                <div class="form-group">
                  <label for="orderInputName">お名前</label>
                  <input type="text" class="form-control" id="orderInputName" name="name">
                </div>
                <div class="form-group">
                  <label for="orderInputRuby">ふりがな</label>
                  <input type="text" class="form-control" id="orderInputRuby" name="ruby">
                </div>
                <div class="form-group">
                  <label for="orderInputAddress">ご住所</label>
                  <input type="text" class="form-control" id="orderInputAddress" name="address">
                </div>
                <div class="form-group">
                  <label for="orderInputBuilding">建物名</label>
                  <input type="text" class="form-control" id="orderInputBuilding" name="building">
                </div>
                <div class="form-group">
                  <label for="orderInputTelNumber">電話番号</label>
                  <input type="tel" class="form-control" id="orderInputTelNumber" name="tel">
                </div>
                <div class="form-group">
                  <label for="orderInputEmail">メールアドレス</label>
                  <input type="email" class="form-control" id="orderInputEmail" name="email">
                </div>
                <button type="submit" class="btn btn-primary">注文する</a>
              </form>
            </div>
          </div><!--/.panel-->
        </div><!--/.col-xs-8-->
      </div><!--/.row-->

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
