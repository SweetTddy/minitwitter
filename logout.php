<?php
  require_once 'config.php';

  session_destroy();

  setcookie ("user_id", "", time() - 3600);
  setcookie ("twitter_name", "", time() - 3600);
  setcookie ("fullname", "", time() - 3600);
  setcookie ("email", "", time() - 3600);
  setcookie ("hash", "", time() - 3600);

  header('Location: index.php');
  exit;