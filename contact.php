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
    <link rel="stylesheet" href="public/css/contact.css">
    <link rel="stylesheet" href="acheteur/userspace/style.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row lenav">
            <?php  include("acheteur/entete.php"); ?>
        </div>
        <div class="row">
            <h3 class="text-center">
                contact
            </h3>
            <form action="" class="form " method="form" >
                <div class="form-inline">
                    <input type="text" class="form-control" placeholder="Votre nom"> 
                    <input type="text" class="form-control" placeholder="Votre télephone">
                </div>
                <div class="form-inline">
                    <input type="email" class="form-control" placeholder="Votre mail"> 
                    <input type="text" class="form-control" placeholder="sujet">
                </div>
                <div class="form-inline">
                   <textarea name="message" id="" cols="51" mawrows="10" maxcols="51" rows="10" class="form-control"></textarea>
                </div>
            </form>
        </div>
        <div class="row">
            <?php include("footer.php"); ?>
        </div>


        <script src="public/js/jquery.min.js "></script>
        <script src="public/js/bootstrap.min.js "></script>
        <script src="public/js/bootstrap.min.js.map "></script>
        <script src="public/js/popover.js "></script>
        <script src="public/js/tooltip.js "></script>
        <script src="public/js/carousel.js "></script>
        <script src="public/js/collapse.js "></script>
        <script src="public/js/monjs.js "></script>
    </div>

</body>

</html>