<?php
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$api_key = getenv('API_TOKEN');
$sub_domain = getenv('SUB_DOMAIN');
define('APP_NO', '1');
define('ID', '1');


// リクエストヘッダーの設定
$options = array(
  'http' => array(
    'method' => 'GET',
    'header' => 'X-Cybozu-API-Token:' . $api_key ."\r\n"
  )
);


// アプリの番号やIDなどのクエリの設定
$query = array(
  'app' => APP_NO,
  'id' => ID
);


$builded_query = http_build_query($query);
$context = stream_context_create($options);
$request_data = file_get_contents(
                  'https://' . $sub_domain . '.cybozu.com/k/v1/record.json' . '?' . $builded_query,
                  FALSE,
                  $context
                );
$json_data = json_decode($request_data, true);

var_dump($json_data);
