 <?php

 /**
 /* Ce formulaire est utilisé pour 2 procédures:
 /*     - Dans la partie administrative (gestion du site), pour alimenter la bdd des journées de roulements
 /*         ==> $page = gestionsite
 /*     - Dans la partie ajout d'une proposition pour ajouter une journée fac dans une proposition
 /*         ==> $page = ajout_proposition
 /*
 /*     @param $idroulement : roulement affiché ds le select
  */
 /* 
  */

 if(isset($_SESSION['message ']))
    {$error = $_SESSION['message'];}
  else
    {$error='';}

if (isset($_GET['page'])) {$page = $_GET['page'];}
else {$page='';}

?>

<div class="text-center text-danger m-2"><?= $error ?></div>

<form id="formajouterjournee" method="post" action="index.php?page=gestionsite">

    <!-- liste UP -->
    <div class="input-group">
        <div class="input-group-prepend mb-2"><span class="input-group-text d-none">UP</span></div>
        <select id="selectionupongletjournees" class="form-control d-none" name="noup">
            <?php foreach ($ups as $up):
            if($up->getId()==$idup){$selected="selected";}
            else {$selected='';}
            ?>
            <option value="<?= $up->getId(); ?>" <?= $selected ?>> <?= $up->getnomup(); ?> </option>
            <?php endforeach; ?> 
        </select>
    </div>

    <!-- liste résidence -->
    <div class="input-group">
        <div class="input-group-prepend mb-2"><span class="input-group-text d-none">Résidence</span></div>
        <select id="selectionresidenceongletjournees" class="form-control d-none" name="noresidence">
            <?php foreach ($residences as $residence):
            if($residence->getIdup()==$idup): //uniquement les résidences de l'up
            if($residence->getId()==$idresidence){$selected="selected";}
            else {$selected='';}
            ?>
            <option value="<?= $residence->getId() ?>" <?= $selected ?> > <?= $residence->getNomresidence() ?> </option>
            <?php endif; endforeach; ?>
        </select>
    </div>

    <div class="input-group">
        <?php 
        //cas d'un ajout dans la partie admin
            if( $page=="gestionsite" ){ ?>
                <div class="input-group-prepend mb-2"><span class="input-group-text d-none">Roulement</span></div>
                    <select id="selectionroulement" class="form-control d-none" name="noroulement">
                        <?php foreach ($roulements as $roulement):
                            if($roulement->getId()==$idroulement){$selected="selected";}
                            else {$selected='';}
                            ?>
                            <option value="<?= $roulement->getId(); ?>" <?= $selected ?> ><?= $roulement->getNoroulement(); ?></option> 
                        <?php endforeach; ?>
                    </select>
            <?php } 
        //cas d'un ajout lors d'une proposition avec journée fac
        //champ input nécessaire pour le traitement de l'information
            if( $page == "ajout_proposition")
            {
                foreach ($roulements as $roulement) 
                {
                   if($roulement->getNoroulement()=="FAC") { ?> <input class='d-none' type="text" name="noroulement" value="<?= $roulement->getId(); ?>"> <?php }
                }
            }
            ?>
    </div>
   

    <div class="input-group">
        <div class="input-group-prepend mb-2"><span class="input-group-text">Journée</span></div>
        <input type="text" class="form-control mb-2" id="nomjournee" name="nomjournee" maxlength="10" required>                
    </div>

    <div class="input-group">
        <div class="input-group-prepend mb-2"><span class="input-group-text">Heure PS</span></div>
        <input type="time" class="heurejournee form-control mb-2" id="heureps" name="heureps" maxlength="5" required>                
    </div>

    <div class="input-group">
        <div class="input-group-prepend mb-2"><span class="input-group-text">Lieu PS</span></div>
        <input type="text" class="form-control mb-2" id="lieups" name="lieups" maxlength="30" required>                
    </div>

    <div class="input-group">
        <div class="input-group-prepend mb-2"><span class="input-group-text">Heure FS</span></div>
        <input type="time" class="heurejournee form-control mb-2" id="heurefs" name="heurefs" maxlength="5" required>                
    </div>

    <div class="input-group">
        <div class="input-group-prepend mb-2"><span class="input-group-text">Lieu FS</span></div>
        <input type="text" class="form-control mb-2" id="lieufs" name="lieufs" maxlength="30" required>
    </div>

    <?php 
    if ($page=="ajout_proposition"){?>   
    <textarea id="textarea_commentaires" class="form-control" name="commentaires" rows="5" placeholder="commentaires"></textarea>
    <?php } ?>

   	<div class="text-center">
        <?php
        /** 2 éxécutions différentes selon qu'il s'agit d'une nouvelle proposition avec journée fac
        /** ou s'il s'agit d'une journée rajoutée dans la partie administration **/
        if ($page == "gestionsite" ){
        ?>
    	<button id="ajouterjournee" class="btn btn-primary mt-2" type="submit">Valider</button>
    	<button id="annulerajoutjournee" class="btn btn-primary mt-2" type="submit">Annuler</button>
        <?php } 

         if ($page == "ajout_proposition" ){
        ?>
        <input id="ajouterpropositionfac" formaction="index.php?page=ajout_proposition&jour=<?= $currentdate ?>&journeefac" class="btn btn-primary mt-2" type="submit" value="Valider">
        <a id="btn_connexion" href="index.php?page=calendrier" class="btn btn-primary mt-2">Annuler</a>
        <?php } ?>
    </div>
</form>