<?php
/**
 * order.php
 */

session_start();
require_once 'vendor/autoload.php';
require_once './Config/config.php';
require_once './DB/mysql.php';
require_once './DB/cart.php';


//----------
// POSTチェック
//----------
$post_names = array(
    'name',
    'ruby',
    'address',
    'building',
    'tel',
    'email'
);
foreach ($post_names as $post_name) {
    if (!array_key_exists($post_name, $_POST)) {
        print 'POSTデータが不正です。';
        exit;
    }
}

/*
POSTされたデータにhogeに結びついたものがないと
$_POST['hoge']
は生成されません。

存在しない要素名にアクセスするとエラーが発生する（エラーメッセージが
表示されない設定の場合表示はされないが、内部的にはエラーが発生している)
ため、array_key_exists関数で要素名が存在するか確認している。

if (!array_key_exists('hoge', $_POST)) {
    print 'error';
}

今回の場合、チェックする項目が多いため、
要素名を配列化し、それをforeachで回していちいち
if (!array_key_exists('hoge', $_POST)) {
    print 'error';
}
を繰り返し書かないようにしている。
 */

// ご注文内容の文字列作る
$order_text = '';
foreach ($_SESSION['Cart'] as $cart) {
    $order_text .= '■'. $cart['name'] ."\n";
    $order_text .= 'サイズ: '. $cart['specification']['size']['name'] ."\n";
    $order_text .= '単価: '. number_format($cart['specification']['price']) ."\n";
    $order_text .= '個数: '. number_format($cart['quantity']) ."\n";
    $order_text .= '小計: '. number_format($cart['specification']['price'] * $cart['quantity']) ."\n\n";
}
$order_text .= '\n';
$order_text .= '合計: '. number_format(getCartTotalAmount()) ."\n";

$body = <<<EOT

{$_POST['name']}様

ICT PIZZAをご利用いただきありがとうございます。
以下の内容でご注文を承りました。
お届けまでしばらくお待ち下さい。

{$order_text}

ご利用ありがとうございました。
EOT;



// メール送信
$config = array(
    'host' => MAIL_HOST,
    'port' => MAIL_PORT,
    'auth' => true,
    'debug' => false,
    'username' => MAIL_USER,
    'password' => MAIL_PASS
);

$headers  =  array (
    'To' => $_POST['email'],
    'From' => MAIL_SENDER,
    'Subject' => '[ICT PIZZA] 注文完了メール'
);

$mailto = $_POST['email'];


$smtp =& Mail::factory('smtp', $config);
$smtp->send($mailto, $headers, $body);


// カート内を削除します
$_SESSION['Cart'] = array();

// 送ったらトップページへ戻ります。
header('Location: index.php');

