<?php
/**
 * JMT
 * Février 2021
 * Formulaire d'ajout de proposition de journee par un agent (formproposition)
 * permet de saisir, sur une date sélectionnée dans le calendrier, la rédidence, le roulement, la journée concernée,
 * le commentaires lié à la proposition
 * 
 * Seuls les résidences, roulements, journées de l'up de l'agent sont proposés
 *
 * @param   $residences  contient les objets residences
 * @param   $journees  contient les objets journees
 * @param   $roulements  contient les objets roulements
 * @param   $idresidence contient la référence residence affiché par défaut
 * @param   $idroulement contient la référence roulement affiché par défaut
 */
?>

<form id="formproposition" method="post" action="index.php?page=ajout_proposition&jour=<?= $currentdate ?>" > 
    <div class="row">
        <div class="form-group col border m-2 p-3">
            
            <!-- liste résidence -->
            <div class="input-group">
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
            
            <div id="ajaxroulement" class="input-group">
                <div class="input-group-prepend mb-2"><span class="input-group-text">Roulement</span></div>
                <select id="selectionroulement" class="form-control" name="idroulement">
                    <?php foreach ($roulements as $roulement):
                    if($roulement->getIdresidence()==$idresidence): //uniquement les roulements de la résidence
                    if($roulement->getId()==$idroulement){$selected="selected";}
                    else {$selected='';}
                    ?>
                    <option value="<?= $roulement->getId(); ?>" <?= $selected ?> ><?= $roulement->getNoroulement(); ?></option> 
                    <?php endif; endforeach; ?>
                </select>
            </div>

            <div id="ajaxjournees" class="input-group">
                <div class="input-group-prepend mb-2"><span class="input-group-text">Journées</span></div>
                <select id="selectionjournee" class="form-control" name="idjournee">
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
        
