<?php
  require("./app/init.php");
  
  $token->delete($_SESSION[User::$sessionKey],1);
  $user->signout();
  unset($_COOKIE['remember']);
  setcookie('remember','',time()-3600);
  header('Location:index.php');//after signout it will redirect to index.php page
  ?>  