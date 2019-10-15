<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require($path . '/app/controller/controller.php');
session_start();
navbar();
notifications();
if (isset($_GET['logout']))
    logout();
login();
if (isset($_GET['takepic']))
    takepic();
if (isset($_SESSION['username']) && isset($_GET['profile']))
    user();
if (!isset($_GET['takepic']) && !isset($_GET['forgot'])
    && !isset($_GET['mail_password_confirmation'])
    && !isset($_GET['profile']))
    wall();
footer();
