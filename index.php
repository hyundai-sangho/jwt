<?php

require_once 'includes/config.php';
require_once 'classes/JWT.php';

// jwt에 사용할 header 값
$header = [
  'type' => 'JWT',
  'alg' => 'HS256',
];

// jwt에 사용할 payload 값
$payload = [
  'user_id' => 123,
  'roles' => [
    'ROLE_ADMIN',
    'ROLE_USER',
  ],
  'email' => 'chosangho@naver.com'
];

$jwt = new JWT();
$token = $jwt->generate($header, $payload, SECRET, 360);
// $token = $jwt->generate($header, $payload, SECRET);

echo $token;
?>
