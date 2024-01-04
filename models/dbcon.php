<?php 

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "nc_ecom_db";

    //Creating db connection
    $con = mysqli_connect($host, $username, $password, $database);

    //check db connection
    if(!$con){
        die("Connection failed". mysqli_connect_error());
    } else{
       // echo "Connected successfully!";
    }
