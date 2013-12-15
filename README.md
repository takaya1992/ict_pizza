ict_pizza
=========

勉強会用


## DBの準備

DB/sql/mysql-schema.sql
にテーブル構造のSQLを、
DB/sql/mysql-data.sql
にサンプルデータのSQLを置いたので

```bash
mysql -u hoge -p dbname < DB/sql/mysql-schema.sql
```
とかして、テーブル作ってください。

## 設定ファイル

`Config/config.sample.php`をコピーし、`Config/config.php`とリネームしてください。


```php
<?php

define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', '');
```
以上のようになっているので、それぞれの環境に合わせて値を編集してください。
