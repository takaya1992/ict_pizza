ict_pizza
=========

勉強会用


## DBの準備

`DB/sql/mysql-schema.sql`
にテーブル構造のSQLを、
`DB/sql/mysql-data.sql`
にサンプルデータのSQLを置いたので

```bash
mysql -u hoge -p dbname < DB/sql/mysql-schema.sql
```
とかして、テーブル作ってください。

## 設定ファイル

`Config/config.sample.php`をコピーし、`Config/config.php`とリネームしてください。


```php
<?php
// DBの設定
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', '');


// メールの設定
define('MAIL_HOST',   '');
define('MAIL_PORT',   0);
define('MAIL_USER',   '');
define('MAIL_PASS',   '');
define('MAIL_SENDER', '');
```
以上のようになっているので、それぞれの環境に合わせて値を編集してください。

Gmailの場合は以下のようになります。
```php
<?php
// メールの設定
define('MAIL_HOST',   'ssl://smtp.gmail.com');
define('MAIL_PORT',   465);
define('MAIL_USER',   'username');
define('MAIL_PASS',   'password');
define('MAIL_SENDER', 'username@gmail.com');
```

## Composer

RubyでいうBundler、PerlでいうCartonのようなパッケージ・ライブラリ管理のしくみです。  
環境に依存せずにいい感じにライブラリをインストールすることができます。

### Linux・Macの場合

#### Composer本体のインストール

プロジェクト内で以下を実行

```bash
curl -s http://getcomposer.org/installer | php
```

#### Composerを使ってライブラリをインストール

```bash
php composer.phar install
```
