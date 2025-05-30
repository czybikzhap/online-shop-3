<?php

session_start();
unset($_SESSION['user']);

//unset($_COOKIE['user']);
//setcookie('user', null, time() - 3600);
//header('Location: /login');
