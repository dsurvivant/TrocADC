<?php
/**
 * JMT
 * Février 2021
 * Formulaire d'ajout de proposition de journee par un agent (formproposition)
 * permet de saisir, sur une date sélectionnée dans le calendrier, la rédidence, le roulement, la journée concernée,
 * le commentaires lié à la proposition
 *
 * @param   $journees  contient les objets journees
 * @param   $roulements  contient les objets roulements
 */
?>

<form id="formproposition" method="post" action="index.php?page=ajout_proposition&jour=<?= $currentdate ?>" > 
    <div class="row">
        <div class="form-group col border m-2 p-3">
            <!--
              <label for="input_up">UP</label>
              <input id="input_up" type="text" class="form-control" name="idup" value="1" readonly>
              <label for="input_residence">Résidence</label>
              <input id="input_residence" type="text" class="form-control" name="idresidence" value="1" readonly>
            -->
            <div class="input-group">
                <div class="input-group-prepend mb-2"><span class="input-group-text">Roulement</span></div>
                <select id="selectionroulement" class="form-control" name="idroulement">
                    <?php foreach ($roulements as $roulement):
                    if($roulement->getId()==$idroulement){$selected="selected";}
                    else {$selected='';}
                    ?>
                    <option value="<?= $roulement->getId(); ?>" <?= $selected ?> ><?= $roulement->getNoroulement(); ?></option> 
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group">
                <div class="input-group-prepend mb-2"><span class="input-group-text">Journées</span></div>
                <select id="selection" class="form-control" name="idjournee">
                    <?php foreach ($journees as $journee):
                    if ($journee->getIdroulement() == $idroulement ){
                    $heureps = new DateTime($journee->getHeureps());
                    $heurefs = new DateTime($journee->getHeurefs());
                    ?>
                    <option value="<?= $journee->getId(); ?>"><?= $journee->getNomjournee() . " " . $heureps->format('H\hi') . " " . $journee->getLieups() . " - " . $heurefs->format('H\hi') . " " . $journee->getLieufs(); ?></option>
                        <?php } endforeach; ?>
                </select>
            </div>

            <textarea id="textarea_commentaires" class="form-control" name="commentaires" rows="5" placeholder="commentaires"></textarea>
        </div>
    </div>
              
    <div class="col text-center"> 
        <!-- bouton soumission formulaire -->               
        <button id="btn_valider_proposition" class="btn btn-primary" name="valider">Valider</button>
        <a id="btn_connexion" href="index.php?page=calendrier" class="btn btn-primary">Annuler</a>
    </div>  
</form>
        
