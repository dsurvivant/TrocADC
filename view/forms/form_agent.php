<?php
/**
 * JMT
 * Février 2021
 * Formulaire de saisi des informations d'un agent
 * Utilisé pour l'inscription ou la modification d'un agent
 */
if (!isset($_SESSION['droits'])) { $_SESSION['droits']=0;} 

  if ( $_SESSION['droits']==0 )
  { 
    $h2="INSCRIPTION"; 
    $page = 'inscription';
  }
  else
  { 
    $h2= "Informations Agent";
    $page = 'ficheagent';
  }
?>
  <div class="container" id="formAgent">

      <hr>
      <div class="row text-center text-monospace"><h2 class="col"><?= $h2; ?></h2></div>
      <!-------------------message limitation au 171 --------------------------->
      <p class="text-danger text-center">
        ATTENTION APPLIWEB EN TEST. <br> 
        SEULES LES INSCRIPTIONS DU 171 SERONT PRISES EN COMPTE. <br>
      </p>
      <!------------------------------------------------------------------------>
      <hr>
      <div class="row text-danger text-center p-1"><h3 id="message_form_agent" class="col"><?= $_SESSION['message']; ?></h3></div>
      
      <form id="formagent" method="post" action="index.php?page=<?= $page ?>" > 
          <div class="row">
              <div class="form-group col border m-2 p-3">
                <label for="input_nocp">N° CP</label>
                <input id="input_nocp" type="text" class="form-control verifmodif" name="nocp" value="<?= $nocp ?>"<?php if($page=='ficheagent'){ echo "readonly"; } ?>>

                 <label for="input_nom">Nom</label>
                <input id="input_nom" type="text" class="form-control verifmodif" name="nom" value="<?= $nom ?>">

                <label for="input_prenom">Prenom</label>
                <input id="input_prenom" type="text" class="form-control verifmodif" name="prenom" value="<?= $prenom ?>">

                <label for="input_telephone">Téléphone</label>
                <input id="input_telephone" type="text" class="form-control verifmodif" name="telephone" value="<?= $telephone ?>">
                <p class="help text-danger m-0 text-center">Numéro de téléphone non valable</p>

                <label for="input_email">email</label>
                <input id="input_email" type="text" class="form-control verifmodif" name="email" value="<?= $email ?>">
                 <p class="help text-danger m-0 text-center">Format email non valable</p>

                <label for="input_password">Mot de passe</label>
                <input id="input_password" type="password" class="form-control" name="password" value="">

                <label for="input_confirmpassword">Confirmer Mot de passe</label>
                <input id="input_confirmpassword" type="password" class="form-control" name="confirmpassword" value="">
                <p class="help text-danger m-0 text-center">Les mots de passe ne sont pas identiques</p>
              </div>


              <!-- DEVELOPPEMENT FUTUR POUR EXTENSION AU DELA DU 171
              <div class="form-group col border m-2 p-3">
                <div class="form-group col border m-2 p-3">
                  <label for="input_roulement">Roulement</label>
                  <input id="input_roulement" type="text" class="form-control verifmodif" name="idroulement" value="<?= $idroulement ?>">

                  <label for="input_residence">Résidence</label>
                  <input id="input_residence" type="text" class="form-control verifmodif" name="idresidence" value="?">

                   <label for="input_up">UP</label>
                   <input id="input_up" type="text" class="form-control verifmodif" name="idup" value="?">
                </div>  
              </div>
              -->


              <?php
              /** ADMINISTRATION */
              if ( isset($_GET['id'])) { $id = $_GET['id']; }
              if ($_SESSION['droits']==1)
              {?>
                <div class="form-group col m-2 p-3">

                  <label for="input_id">Id</label>
                  <input id="input_id" type="text" class="form-control verifmodif" name="id" value="<?= $id ?>" readonly >

                  <label for="input_droits">Droits</label>
                  <input id="input_droits" type="text" class="form-control verifmodif" name="droits" value="<?= $droits ?>">

                  <label for="input_dateinscription">Date d'inscription</label>
                  <input id="input_dateinscription" type="text" class="form-control verifmodif" readonly name="dateinscription" value="<?= $dateinscription ?>">

                  <input id="check_actif" type="checkbox" class="form-group mt-3" name="actif" <?php if($actif) { echo "checked"; } ?>>
                  <label class="form-check-label" for="check_actif">Actif</label>

                </div>
              <?php
              }?>
          </div>
        </form>

          <div class="row">
              <div class="col text-center">
                <?php
                /**  */
                if ($_SESSION['droits']==0)
                {?>
                  <button id="btn_valider_inscription" class="btn_form_agent btn btn-secondary" name="valider">Valider</button>
                  <a id="btn_connexion" href="index.php?page=parametres" class="btn btn-secondary">Annuler</a>
                  <?php
                }

                
                /** ADMINISTRATION */
                if ($_SESSION['droits']==1)
                {?>
                    <button id="btn_modifier_agent" class="btn_form_agent btn btn-secondary btn-danger" name="modifier" disabled="enabled">Modifier</button>
                    <a id="btn_connexion" href="index.php?page=gestionsite" class="btn btn-secondary btn-danger">Annuler</a>
                    <button id="btn_connexion" type="submit" class="btn btn-secondary btn-danger" name="supprimer" disabled>Supprimer</button>
                <?php
                }?>
              </div>
          </div>
  </div>