<?php
  ob_start();
  require('view/modals/modal_connexion.php');
  $content = ob_get_clean();
  $titre="Demande de connexion";

  require('template_connexion.php');