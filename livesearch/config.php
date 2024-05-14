<?php

$con = mysqli_connect("localhost","","root","ecommerce_laravel1");

if(!$con){
    echo "COnnection Failed" . mysqli_connect_error();
}
?>
