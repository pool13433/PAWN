<?php 
session_start();
if(!empty($_SESSION['member'])){
    unset($_SESSION['member']);
}
echo '<meta http-equiv="refresh" content="0; URL=\'../\'" />';
    