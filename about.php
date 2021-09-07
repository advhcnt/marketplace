<?php session_start(); 
include 'include/panier_fonction.php';
#include 'add_panier.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/about.css">
    <link rel="stylesheet" href="acheteur/userspace/style.css">
    <title>About</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row lenav">
            <?php  include("acheteur/entete.php"); ?>
        </div>
        <div class="row">
            <h3 class="text-center">
                About
            </h3>
            
        </div>
        <div class="row">
            <?php include("footer.php"); ?>
        </div>



        <script src="public/js/bootstrap.min.js "></script>
        <script src="public/js/collapse.js "></script>
        <script src="public/js/accordion.js "></script>
    </div>

</body>

</html>