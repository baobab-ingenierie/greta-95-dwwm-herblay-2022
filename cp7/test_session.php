<?php
session_start();
if (!isset($_SESSION['is_auth'])) {
    header('location:index.php');
}
