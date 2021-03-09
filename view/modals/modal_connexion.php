<?php
  /**
   * JMT62 JANVIER 2021
   * 
   * formmulaire de connexion: formconnexion type POST
   * en entré : $_SESSION['error'], contient un message d'erreur ou vide
   * 2 champs en retour: $_POST['nocp'], $_POST['password']
   * bouton de validation: #btn_connexion
   */

?>
<?php
  if(isset($_SESSION['message']))
    {$error = $_SESSION['message'];}
  else
    {$error='';}
?>

<div class="container">
  <!-- Le bouton d'ouverture de la fenêtre modale de connexion -->
  <button id="btn_openformconnexion" type="button" class="btn btn-danger mt-3" data-toggle="modal" data-backdrop="static"data-target="#modal" data-keyboard="false">Cliquez pour vous connecter</button>

  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">TrocADC</h5>
          <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>-->
        </div>

        <div class="modal-body">
          <div class="text-center"><?= $error ?></div>
          <form id="formconnexion"  method="post" action="index.php?page=connexion" >
            <div class="form-group">
              <label for="input_nocp">N° CP</label>
              <input id="input_nocp" type="text" class="form-control" name="nocp">
            </div>

            <div class="form-group">
              <label for="input_mdp">Mot de passe</label>
              <input id="input_mdp" type="password" class="form-control" name="password">
            </div>

            <div class="form-group">
                <button id="btn_connexion" type="submit" class="btn btn-primary">Connexion</button>
            </div>
          </form>

           <a class="float-right" href="index.php?page=inscription">Inscription</a>
        </div>
      </div>
    </div>
  </div>

</div>