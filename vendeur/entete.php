<nav class="navbar navbar-default navbar-fixed-top " role="navigation" style="margin:auto;">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#moncallapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar text-secondary"></span>
            <span class="icon-bar text-secondary"></span>
            <span class="icon-bar text-secondary"></span>
        </button>
        <a class="navbar-brand" href="#">DJAWAO</a>
    </div>

    <div class="display-flex ">
        <div class="collapse navbar-collapse mx:auto" id="moncallapse">
            <ul class="row entete ">
                <div class="nav navbar-nav  Part1">
                    <li class="active mesnavbarliens"><a href="http://127.0.0.1/marketplace/acheteur/" class="navbar-link">Acceuil</a></li>
                    <li class="mesnavbarliens"><a href="#" class="navbar-link "> Boutique</a></li>
                    <li class="mesnavbarliens"><a href="http://127.0.0.1/marketplace/vendeur/login_vendeur.php" class="navbar-link "> Vendeur</a>
                    </li>
                    <li class="mesnavbarliens"><a href="http://127.0.0.1/marketplace/about.php" class="navbar-link ">A propos</a></li>
                    <li class="mesnavbarliens"><a href="http://127.0.0.1/marketplace/acheteur/userspace/chat.php" class="navbar-link ">Chat</a></li>
                    <li class="mesnavbarliens"><a href="http://127.0.0.1/marketplace/contact.php" class="navbar-link ">Contact</a></li>
                    <?php 
						if(isset($_SESSION["id_client"] ) && !empty($_SESSION) && isset($_SESSION["id_client"] ))
						{
                            ?>
                    <li class="mesnavbarliens"><a href="http://127.0.0.1/marketplace/include/panier.php"
                            class="navbar-link  visible-xs visible-sm"><span
                                class="glyphicon glyphicon-shopping-cart"></span><span class="badge badge-success"
                                style="background-color:red"><?=compterArticles();?></span>
                        </a>
                    </li>
                    <li><a href="http://127.0.0.1/marketplace/acheteur/userspace"
                            class="navbar-link  visible-xs visible-sm ">Profil</a> </li>

                    <?php
                        }
                        else
                        {
                            ?>
                    <li class="mesnavbarliens"><a href="http://127.0.0.1/marketplace/acheteur/login.php"
                            class="navbar-link  visible-xs visible-sm">connexon</a></li>
                    <li class="mesnavbarliens"><a href="http://127.0.0.1/marketplace/acheteur/register_client.php"
                            class="navbar-link  visible-xs visible-sm">inscription</a></li>
                    <?php
                        }
                            ?>

                </div>

                <div class="Part2 nav navbar-nav">
                    <?php 
						if(isset($_SESSION["id_client"] ) && !empty($_SESSION) && isset($_SESSION["id_client"] ))
						{
?>
                    <li class="mesnavbarliens visible-md visible-lg"><a
                            href="http://127.0.0.1/marketplace/include/panier.php" class="navbar-link  "><span
                                class="glyphicon glyphicon-shopping-cart"></span><span class="badge badge-success"
                                style="background-color:red"><?=compterArticles();?></span>
                        </a>
                    </li>
                    <li class="mesnavbarliens visible-md visible-lg "><a
                            href="http://127.0.0.1/marketplace/acheteur/userspace"><img
                                src="http://127.0.0.1/marketplace/acheteur/avatar.jpg" alt="" srcset=""
                                class="img img-responsive img-circle"
                                style="height:50px;width:50px;margin-top:-10px"></a> </li>

                    <?php
						}
						else
						{
?>
                    <li class="visible-lg visible-xl">
                        <div>
                            <form action="http://127.0.0.1/marketplace/acheteur/login2.php" class="navbar-form form " method="post">
                                <div class="form-inline ">
                                    <input type="email " class="form-control input-sm  "
                                        placeholder="Ex:nouyoin@gmail.com " required name="mail">
                                    <input type="password" class="form-control input-sm  " minlength="8 " required
                                        name="password">
                                    <button type="submit " class="btn boutons input-sm  "
                                        name="submit">Connexion</button>
                                </div>
                            </form>
                        </div>
                    </li>

                    <li>
                        <div class=" buttons_div " style="margin-right:-100vw; display:flex;margin-top:10px">
                            <a href="http://127.0.0.1/marketplace/acheteur/login.php"><button
                                    class=" visible-md btn boutons text-white btn-sm mr-5 ">Connexion</button></a>
                            <a href="register_client.php"><button
                                    class="visible-md visible-lg visible-xl mt-5 btn boutons  text-white btn-sm mr-5 ">Inscription</button></a>
                        </div>
                    </li>
                    <?php
						}
                        
?>
                </div>

            </ul>

        </div>


    </div>
</nav>