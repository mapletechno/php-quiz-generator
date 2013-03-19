<?php

function trim_str_array($str_array) {
  $result = array();
  foreach ($str_array as $str) {
    $pr = trim($str);
    if (strlen($pr) > 0)
      $result[] = $pr;
  }
  return $result;
}

function parse_problems($quizzes) {
  $result = array();
  foreach ($quizzes as $quiz) {
    $t = preg_split('/(\n\@)/', $quiz);
    unset($type);
    if (count($t) > 1)
      $type = 'single';
    if (!isset($type)) {
      $t = preg_split('/(\n\#)/', $quiz);
      if (count($t) > 1)
        $type = 'multiple';
    }
    if (!isset($type)) {
      $t = preg_split('/(\n\[)/', $quiz);
      if (count($t) > 1)
        $type = 'text';
    }
    if (!isset($type)) {
      $t = preg_split('/(\n\{)/', $quiz);
      if (count($t) > 1)
        $type = 'code';
    }
    $obj['type'] = $type;
    $desc = trim($t[0]);
    $desc = preg_replace('/(\r\n|\r|\n)/', '<br/>', $desc);
    $desc = '<p>' . preg_replace('/\s*\<br\/\>\s*\<br\/\>\s*/', '</p><p>', $desc) . '</p>';
    $obj['description'] = preg_replace('/\s*\<br\/\>\s*/', ' ', $desc);
    unset($obj['choices']);
    if (strcmp($type, 'single') == 0 || strcmp($type, 'multiple') == 0) {
      $obj['choices'] = array();
      for ($i = 1; $i < count($t); ++$i)
        $obj['choices'][] = $t[$i];
    }
    unset($obj['answer']);
    if (strcmp($type, 'text') == 0 || strcmp($type, 'code') == 0) {
      $obj['answer'] = trim($t[1]);
      $obj['answer'] = substr($obj['answer'], 0, strlen($obj['answer']) - 1);
      $obj['answer'] = trim($obj['answer']);
    }
    // when everything done
    $result[] = $obj;
  }
  return $result;
}

function parse_quiz($quiz_specs) {
  $specs = file_get_contents($quiz_specs);
  $specs = preg_split('/(\n|^)\+/', $specs);
  $specs = trim_str_array($specs);
  $meta = trim_str_array(preg_split('/\n/', $specs[0]));
  foreach ($meta as $m) {
    $t = explode(':', $m);
    $k = strtolower(trim($t[0]));
    $k = str_replace(' ', '_', $k);
    $struct['meta'][$k] = trim($t[1]);
  }
  $struct['quizzes'] = array();
  for ($i = 1; $i < count($specs); ++$i)
    $struct['quizzes'][] = $specs[$i];
  $struct['quizzes'] = parse_problems($struct['quizzes']);
  return $struct;
}

function dump_quiz_summary($id) {
  $quiz_full = 'quizzes/' . $id;
  $specs = $quiz_full . '/specs.md';
  $cases_dir = $quiz_full . '/testcases';
  $submit_dir = $quiz_full . '/submissions';
  $quiz = parse_quiz($specs);
?>
  <div id="<?php echo $id ?>">
    <table border="1">
      <thead>
        <tr>
          <th colspan="2"><h1><?php echo $id ?></h1></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>Deadline</th>
          <td><?php echo $quiz['meta']['deadline'] ?></td>
        </tr>
        <tr>
          <th>Hard deadline</th>
          <td><?php echo $quiz['meta']['hard_deadline'] ?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a href="quiz.php?id=<?php echo $id ?>">Attempt</a></td>
        </tr>
      </tfoot>
    </table>
  </div>
<?php
}

function dump_quiz($id) {
  $quiz_full = 'quizzes/' . $id;
  $specs = $quiz_full . '/specs.md';
  $cases_dir = $quiz_full . '/testcases';
  $submit_dir = $quiz_full . '/submissions';
  $quiz = parse_quiz($specs);
?>
  <h1><?php echo $id ?></h1>
  <p>
    The deadline for this assignment is <?php echo $quiz['meta']['deadline'] ?>.
    The hard deadline for this assignment is <?php echo $quiz['meta']['hard_deadline'] ?>.
  </p>
<?php
  for ($i = 0; $i < count($quiz['quizzes']); ++$i) {
    $q = $quiz['quizzes'][$i];
    $number = $i + 1;
?>
    <h2>Problem <?php echo $number ?></h2>
    <?php echo $q['description'] ?>
<?php
  }
?>
<?php
}
