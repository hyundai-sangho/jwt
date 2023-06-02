<?php

const TOKEN = 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFMyNTYifQ.eyJ1c2VyX2lkIjoxMjMsInJvbGVzIjpbIlJPTEVfQURNSU4iLCJST0xFX1VTRVIiXSwiZW1haWwiOiJjaG9zYW5naG9AbmF2ZXIuY29tIiwiaWF0IjoxNjg1NzIwODUxLCJleHAiOjE2ODU3MjA5MTF9.-mvMnBc6DaZQFpw_hRjUsa1Oh9aA7mznvdAbSlwD-jk';

require_once 'includes/config.php';
require_once 'classes/JWT.php';

$jwt = new JWT();
var_dump($jwt->isValid(TOKEN));
