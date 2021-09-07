<!DOCTYPE php>
<php lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="public/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/css/loader.css">
        <title>Accueil</title>
    </head>

    <body>

        <div class="loader visible-md visible-lg">

            <span class="lettre">D</span>
            <span class="lettre">J</span>
            <span class="lettre">A</span>
            <span class="lettre">W</span>
            <span class="lettre">A</span>
            <span class="lettre">O</span>
            <span class="lettre">.</span>
            <span class="lettre">C</span>
            <span class="lettre">O</span>
            <span class="lettre">M</span>

        </div>
        <div class="loader visible-xs visible-sm align-item-center">

            <span class="lettre" style="">D</span>
            <span class="lettre" style="">J</span>
            <span class="lettre" style="">A</span>
            <span class="lettre" style="">W</span>
            <span class="lettre" style="">A</span>
            <span class="lettre" style="">O</span>
           

        </div>


        <?php 
    $i=time();
    $b=$i+500;
    while($i<$b)
    {
        ?>
        <script src="js/loader.js"></script>
        <?php
        $i++;
    }?>
        <script src="public/js/loader.js"></script>
    </body>
</php>