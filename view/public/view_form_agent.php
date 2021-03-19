<?php
  
 ob_start();
 	
  include("view/forms/form_agent.php");  
$main = ob_get_clean();

require('view/public/template_main.php');
?>