<?php

require_once('pqg.inc.php');

if (!isset($_POST) || !isset($_POST['action']) || $_POST['action'] != 'submit'):

  global $title;
  $title = url_to_string($_GET['id']);
  require('templates/header.inc.php');
  dump_quiz($_GET['id']);
  require('templates/footer.inc.php');

else:

  // header('Location: .');
  var_dump($_POST);

endif;
