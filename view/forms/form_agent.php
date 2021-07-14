<?php
/**
 * JMT
 * Février 2021
 * Formulaire de saisi des informations d'un agent
 * Utilisé pour l'inscription ou la modification d'un agent
 */


if (isset($_GET['idroulement'])) { $idroulement = $_GET['idroulement'];}
else { $idroulement = '';}

if (!isset($_SESSION['droits'])) { $_SESSION['droits']=0;} 

  if ( $_SESSION['droits']==0 ) { $page = 'inscription';}
  else { $page = 'ficheagent';}

if (!isset($idup)) { $idup = ''; }
if (!isset($idresidence)) {$idresidence = ''; }
if (!isset($idroulement))  { $idroulement = ''; }

?>
  <div id="ficheagent" class="container">

      <hr>

      <div class="row text-center text-monospace"><h2 class="col"><?= $titrepage; ?></h2></div>
      
      <!------------------------------------------------------------------------>
      <hr>
      <div class="row text-danger text-center p-1"><h3 id="message_form_agent" class="col"><?= $_SESSION['message']; ?></h3></div>
      
      <form id="formagent" class="row pt-2 mb-4"  method="post" action="index.php?page=<?= $page ?>" > 
        <section  class = "col m-1">
          
          <!-- liste UP -->
            <div class="input-group">
              <div class="input-group-prepend mb-2"><span class="input-group-text">UP</span></div>
                <select id="selectionup" class="form-control" name="noup">
                  <option value="vide" >  </option>
                  <?php foreach ($ups as $up):
                    if($up->getId()==$idup){$selected="selected";}
                    else {$selected='';}
                  ?>
                    <option value="<?= $up->getId(); ?>" <?= $selected ?>> <?= $up->getnomup(); ?> </option>
                  <?php endforeach; ?> 
                </select>
            </div>

          <!-- liste résidence -->
            <div id="ajaxresidence" class="input-group">
              <div class="input-group-prepend mb-2"><span class="input-group-text">Résidence</span></div>
              <select id="selectionresidence" class="form-control" name="noresidence">
                <?php foreach ($residences as $residence):
                                if($residence->getIdup()==$idup): //uniquement les résidences de l'up
                                if($residence->getId()==$idresidence){$selected="selected";}
                                else {$selected='';}
                                ?>
                                  <option value="<?= $residence->getId() ?>" <?= $selected ?> > <?= $residence->getNomresidence() ?> </option>
                                <?php endif; endforeach; ?>
              </select>
            </div>

          <!-- liste roulement -->
            <div id="ajaxroulement" class="input-group">
              <div class="input-group-prepend mb-2"><span class="input-group-text">Roulement</span></div>
              <select id="selectionroulement" class="form-control" name="noroulement">
                <?php foreach ($roulements as $roulement):
                            if($roulement->getIdresidence()==$idresidence): //uniquement les roulements de la résidence
                                if($roulement->getId()==$idroulement){$selected="selected";}
                                else {$selected='';}
                                ?>
                              <option value="<?= $roulement->getId(); ?>" <?= $selected ?> ><?= $roulement->getNoroulement(); ?></option> 
                          <?php endif; endforeach; ?>
              </select>
            </div>
         
          <div class="input-group mb-2">
            <div class="input-group-prepend"><span class="input-group-text text-secondary">No cp</span></div>
            <input id="input_nocp" type="text" class="form-control verifmodif" name="nocp" value="<?= $nocp ?>"<?php if($page=='ficheagent'){ echo "readonly"; } ?>>
          </div>
            
          <div class="input-group mb-2">
            <div class="input-group-prepend"><span class="input-group-text text-secondary">Nom</span></div>
            <input id="input_nom" type="text" class="form-control verifmodif" name="nom" value="<?= $nom ?>">
          </div>
           
          <div class="input-group mb-2">
            <div class="input-group-prepend"><span class="input-group-text text-secondary">Prenom</span></div>
            <input id="input_prenom" type="text" class="form-control verifmodif" name="prenom" value="<?= $prenom ?>">
          </div>
            
          <div class="input-group mb-2">
              <div class="input-group-prepend"><span class="input-group-text text-secondary">Tel</span></div>
              <input id="input_telephone" type="text" class="form-control verifmodif" name="telephone" value="<?= $telephone ?>">
              <p class="help text-danger m-0 text-center">Numéro de téléphone non valable</p>
          </div>

          <div class="input-group mb-2">
            <div class="input-group-prepend"><span class="input-group-text text-secondary">Email</span></div>
            <input id="input_email" type="text" class="form-control verifmodif" name="email" value="<?= $email ?>">
              <p class="help text-danger m-0 text-center">Format email non valable</p>
          </div>

          <div class="input-group mb-2">
            <div class="input-group-prepend"><span class="input-group-text text-secondary">Mot de passe</span></div>
            <input id="input_password" type="password" class="form-control" name="password" value="">
          </div>

          <div class="input-group mb-2">
            <div class="input-group-prepend"><span class="input-group-text text-secondary">Confirmer MDP</span></div>
            <input id="input_confirmpassword" type="password" class="form-control" name="confirmpassword" value="">
            <p class="help text-danger m-0 text-center">Les mots de passe ne sont pas identiques</p>
          </div>
        </section>

        <?php
        /** ADMINISTRATION */
        if ( isset($_GET['id'])) { $id = $_GET['id']; }
        if ($_SESSION['droits']==1)
        {?>
        <section  class = "col m-1">
              
                <div class="form-group col m-2 p-3">
                  <label>Id: <?= $id ?></label> <br>

                  <label>Inscrit depuis le: <?= date('d M Y', $dateinscription); ?></label> <br>

                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><span class="input-group-text text-secondary bg-white">Droits</span></div>
                    <input id="input_droits" type="text" class="form-control verifmodif" name="droits" value="<?= $droits ?>">
                  </div>

                  <input id="check_actif" type="checkbox" class="form-group mt-3" name="actif" <?php if($actif) { echo "checked"; } ?>>
                  <label class="form-check-label" for="check_actif">Actif</label>

                </div>
              
        </section>
        <?php
        }?>
      </form>

      <section class="row">
        <div id="form_boutons" class="col-12 text-danger text-center"> 
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
              <button id="btn_modifier_agent" class="btn_form_agent btn btn-secondary btn-danger">Modifier</button>
              <a id="btn_connexion" href="index.php?page=gestionsite" class="btn btn-secondary btn-danger">Annuler</a>
              <button id="btn_supprimer_agent" class="btn btn-secondary btn-danger">Supprimer</button>
                <?php
            }?>
        </div>

        <div id="confirmer_suppression" class="col-12 text-danger text-center" style="display: none;">
          <?php
             /** ADMINISTRATION */
            if ($_SESSION['droits']==1)
            {?>
              <button id="btn_confirmer_suppression" class="btn btn-secondary btn-danger">Confirmer la suppression</button>
              <button id="btn_annuler_confirmation" class="btn btn-secondary btn-danger">Annuler</button>
                <?php
            }
          ?>
        </div>

        </section>
  </div>