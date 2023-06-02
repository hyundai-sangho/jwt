<?php

class JWT
{
  public function generate(array $header, array $payload, string $secret, int $validity = 86400): string
  {

    // $validity = 86400 => 60초 x 60분 x 24 시간 = 하루
    if ($validity > 0) {
      $now = new DateTime();
      $expiration = $now->getTimestamp() + $validity; // 토큰 만료 시간
      $payload['iat'] = $now->getTimestamp(); // 발급된 시간 (issued at) = iat
      $payload['exp'] = $expiration;
    }

    $base64Header = base64_encode(json_encode($header)); // $header를 json으로 변환 후 base64로 인코딩해 $base64Header에 저장
    $base64Payload = base64_encode(json_encode($payload)); // $payload를 json으로 변환 후 base64로 인코딩해 $base64Header에 저장

    $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
    $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

    // jwt에 사용할 signature 값
    $secret = base64_encode($secret);

    $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);
    $base64Signature = base64_encode($signature);
    $signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);
    $jwt = $base64Header . '.' . $base64Payload . '.' . $signature;

    return $jwt;
  }

  public function check(string $token, string $secret): bool
  {
    $header = $this->getHeader($token);
    $payload = $this->getPayload($token);

    $verificationToken = $this->generate($header, $payload, $secret, 0);

    return $token === $verificationToken;
  }

  public function getHeader(string $token)
  {
    $array = explode('.', $token);
    $header = json_decode(base64_decode($array[0]), true);

    return $header;
  }

  public function getPayload(string $token)
  {
    $array = explode('.', $token);
    $payload = json_decode(base64_decode($array[1]), true);

    return $payload;
  }

  public function isExpired(string $token): bool
  {
    $payload = $this->getPayload($token);

    $now = new DateTime();

    return $payload['exp'] < $now->getTimestamp();
  }

  public function isValid(string $token): bool
  {
    // preg_match() 함수
    // $token이 정규식에 해당한다면 1을 반환, 틀리면 0을 반환
    return preg_match('/^[A-Za-z0-9\-\_\=]+\.[A-Za-z0-9\-\_\=]+\.[A-Za-z0-9\-\_\=]+$/', $token) === 1;
  }
}
