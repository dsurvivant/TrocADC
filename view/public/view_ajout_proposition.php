<?php
  ob_start();

include("view/forms/form_ajout_proposition.php");  
$main = ob_get_clean();

$titre = "trocADC - Ajout proposition";
require('view/public/template_main.php');
?>