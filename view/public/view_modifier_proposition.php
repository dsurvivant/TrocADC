<?php
  ob_start();

include("view/forms/form_modifier_proposition.php");  
$main = ob_get_clean();

$titre = "trocADC - Modifier une proposition";
require('view/public/template_main.php');
?>