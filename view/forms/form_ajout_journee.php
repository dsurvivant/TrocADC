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

 if(isset($_SESSION['message']))
    {$error = $_SESSION['message'];}
  else
    {$error='';}

if (isset($_GET['page'])) {$page = $_GET['page'];}
else {$page='';}

?>

<div class="text-center text-danger m-2"><?= $error ?></div>

<form id="formajouterjournee" method="post" action="index.php?page=gestionsite">
   <!--
    <div class="input-group">
        <div class="input-group-prepend mb-2"><span class="input-group-text">UP</span></div>
        <input type="text" class="form-control mb-2" id="up" value="1" maxlength="11" name="idup" readonly>  
    </div>

    <div class="input-group">
        <div class="input-group-prepend mb-2"><span class="input-group-text">Résidence</span></div>
        <input type="text" class="form-control mb-2" id="residence" name="idresidence" maxlength="11" value="1" readonly>
    </div>
    -->
    
    <div class="input-group">
        <?php 
        //cas d'un ajout dans la partie admin
            if( $page=="gestionsite" ){ ?>
                <div class="input-group-prepend mb-2"><span class="input-group-text">Roulement</span></div>
                    <select id="selectionroulement" class="form-control" name="noroulement">
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