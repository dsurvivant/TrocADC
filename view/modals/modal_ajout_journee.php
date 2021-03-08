<?php 
/**
 * JMT
 * Février 2021
 * formulaire pour ajouter, modifier, ou supprimer une journée de roulement
 */

?>
<div class="modal fade" id="modalAjoutJournee" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	        <div class="modal-header">
	          <div class="modal-title">Ajout d'une journée</div>
	          <button id="btncloseajoutjournnee" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
	        </div>

	        <div class="modal-body">
	        	<?php include("view/forms/form_ajout_journee.php"); ?>
	        </div>
	    </div>
	</div>
</div>