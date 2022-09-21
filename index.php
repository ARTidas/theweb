<?php
  header("Cache-Control: no-cache, no-store, must-revalidate");
  header("Pragma: no-cache");
  header("Expires: 0");

  error_reporting(E_ALL & ~E_NOTICE);
  ini_set('display_errors', 1);

  require(dirname(__FILE__) . '/models/helpers/log_helper.php');

  LogHelper::add('--------------------------------------------------------------------------------');
  LogHelper::add(date('Y-m-d H:i:s', time()));
  LogHelper::add('Starting up engines...');

  
  echo('Hello world...');


?>
