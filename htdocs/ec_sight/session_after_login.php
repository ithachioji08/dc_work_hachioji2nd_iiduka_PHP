<?php
//セッション開始
session_start();

if(!isset($_SESSION['login_id'])){
    header('Location: index.php');
}