<?php
  date_default_timezone_set("Asia/Dhaka");
  $now=date("Y-m-d H:i:s");  
  
  $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
  $base_path = '/NextPrime_Limited/admin';
  $base_url = $scheme . '://' . $host . $base_path;
