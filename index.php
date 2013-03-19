<?php

require_once('pqg.inc.php');

function show_quiz_summary($quiz_id) {
  dump_quiz_summary($quiz_id);
}

function list_quizzes($dirname) {
  $dir = opendir($dirname);

  // echo '<ul>';
  while (($subdir = readdir($dir)) !== false) {
    if ($subdir == '.' || $subdir == '..')
      continue;
    $subdir_full = $dirname . '/' . $subdir;
    // echo '<li>' . $subdir_full . '</li>';
    if (is_dir($subdir_full)) {
      // list_quizzes($subdir_full);
      show_quiz_summary($subdir);
    }
  }
  // echo '</ul>';

  closedir($dir);
}

list_quizzes('quizzes');

?>