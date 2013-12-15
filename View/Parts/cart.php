<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">買い物カゴ</h3>
  </div>
  <div class="panel-body">
    <?php if (is_array($_SESSION['Cart']) && count($_SESSION['Cart']) == 0): ?>
      <p>現在、カートに商品がありません。</p>
    <?php else: ?>
      <table class="table">
        <tr>
          <th>商品名</th>
          <th>サイズ</th>
          <th>単価</th>
          <th>個数</th>
          <th>小計</th>
        </tr>
        <?php foreach ($_SESSION['Cart'] as $cart): ?>
          <tr>
            <td><?php echo $cart['name']; ?></td>
            <td><?php echo $cart['specification']['size']['name']; ?></td>
            <td style="text-align: right;"><?php echo '¥'. number_format($cart['specification']['price']); ?></td>
            <td style="text-align: right;"><?php echo $cart['quantity']; ?></td>
            <td style="text-align: right;"><?php echo '¥'. number_format($cart['specification']['price'] * $cart['quantity']); ?></td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <th colspan="4">合計</th>
          <td style="text-align: right;"><?php echo '¥'. number_format(getCartTotalAmount()); ?></td>
        </tr>
      </table>
    <?php endif; ?>
    <a href="cart.php" type="button" class="btn btn-primary">個数変更/注文</a>
  </div>
</div>