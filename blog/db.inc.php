<?php

require_once 'env.php';


function db_init()
{
  $pdo = new PDO(
    'mysql:host='.DBHOST.'; dbname='.DBNAME.'; charset=utf8',
    DBUSER,DBPASS,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
  );
  // 値を戻さないと実行先で利用できない
  return $pdo;
}