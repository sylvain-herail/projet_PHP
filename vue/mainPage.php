<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Votre site d'actualité</title>

    <!-- Bootstrap core CSS -->
     <link href="vue/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="vue/cover.css" rel="stylesheet">

  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h1 class="masthead-brand">Actualité</h1>
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="index.php">Home</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner-cover">
            
            <h1>Administrateur :</h1>
            <br>
            <br>
            <?php global $a;?>
            <?php if (!is_null($a)){ ?>

              <p class="lead">
                <a href="index.php?action=deco" class="btn btn-lg btn-default">Deconnexion</a> 

                <p class="lead">Ajouter un flux rss</p>
                <form method="post" action="index.php?action=ajouter">
                  <input type="text" name="ajoutLien">
                  <input type="submit" value="Ajouter">
                </form>

                <p class="lead">Supprimer un flux rss</p>
                <form method="post" action="index.php?action=supprimer">
                  <input type="text" name="supprimerLien">
                  <input type="submit" value="supprimer">
                </form>
                <br>
                <br>
                <p class="lead">Changer le nombre de nouvelles voulues sur la page principale :</p>

                <form method="post" action="index.php?action=changerNombreDeNewsParPage">
                  <input type="text" name="nbNewsParPage">
                  <input type="submit" value="Appliquer">
                </form>

              </p>
            <?php }else{ ?>
                        
                <form class="form-signin" method="post" action="index.php?action=signIn">
                  <input type="text" name="login" class="form-control" placeholder="Login" required autofocus>
                  <input type="password" name="pwd"  class="form-control" placeholder="Password" required>
                  <input type="submit" value="Envoyer">
                </form>

          </div>
            <?php } ?>
        </div>

            <div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading">Toutes vos actualités</div>

                  
                    <table class="table">
                     <thead>
                        <tr>
                          <th>
                            <font>Date :</font>
                          </th>
                          <th>
                            <font>Titre :</font>
                          </th>
                          <th>
                            <font>URL :</font>
                          </th>
                        </tr>
                        
                        <?php foreach ($tabNews as $ligne) {?>
                          
                          <tr>
                            <th>
                              <font><?php echo $ligne['dateInser']; ?></font>
                            </th>
                            <th>
                              <font><?php echo $ligne['titre']; ?></font>
                            </th>
                            <th>
                              <font><a href=<?php echo $ligne['url']; ?>><?php echo $ligne['url']; ?> </a></font>
                            </th>
                          </tr>
                          <?php } ?>
                    </table>

                    <?php
                    for($i=1; $i<=$nombreDePages; $i++)
                    {
                         if($i==$pageActuelle)
                         {
                             echo $i; 
                         }  
                         else
                         { ?>
                              <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                            <?php
                         }
                    }
                    ?>
                  </div>
                  <br>
                  
                
          <div class="mastfoot">
            
              <p>Développé par Combe Etienne et Herail Sylvain</p>
            
          </div>

        

      </div>

    </div>
  </body>
</html>
