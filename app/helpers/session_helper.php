<?php


date_default_timezone_set("Asia/Baghdad");


// server should keep session data for AT LEAST 1 hour = 3600
//ini_set('session.gc_maxlifetime', (3600 /60)*30);
//// each client should remember their session id for EXACTLY 1 hour
//session_set_cookie_params((3600 /60)*5);
session_start();


// Flash message helper
function flash($name = '', $message = '', $class = 'alert alert-success'){
  if(!empty($name)){
    //No message, create it
    if(!empty($message) && empty($_SESSION[$name])){
      if(!empty( $_SESSION[$name])){
          unset( $_SESSION[$name]);
      }
      if(!empty( $_SESSION[$name.'_class'])){
          unset( $_SESSION[$name.'_class']);
      }
      $_SESSION[$name] = $message;
      $_SESSION[$name.'_class'] = $class;
    }
    //Message exists, display it
    elseif(!empty($_SESSION[$name]) && empty($message)){
      $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : 'success';
      echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
      unset($_SESSION[$name]);
      unset($_SESSION[$name.'_class']);
    }
  }
}


function checkPermissionSession($permissionName): bool
{
    return (in_array($permissionName, $_SESSION['permissions']) !== null);
}
