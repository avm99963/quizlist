<?php
require_once("core.php");
require_once('lib/htmlpurifier/library/HTMLPurifier.auto.php');

if (!isset($_POST["id"]) || !isset($_POST["info"])) {
  header("Location: home.php");
  exit();
}

$info = json_decode($_POST["info"], true);

if ($info === null) {
  header("Location: home.php");
}

$quiz = quiz::getQuiz((int)$_POST["id"]);

if ($quiz === false) {
  die("This quiz doesn't exist.");
}

if ($quiz["addition"] == quiz::PRIVATE_ADD) {
  security::checkType(0);
}

$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);

foreach ($info as $i => &$q) {
  $q["question"] = $purifier->purify($q["question"]);
  $q["rightanswer"] = $purifier->purify($q["rightanswer"]);
  foreach ($q["answers"] as &$a) {
    $a = $purifier->purify($a);
    $a = preg_replace('/<img[^>]*src="[^>]*\/grade_[^>]*"[^>]*>/i', "", $a);
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([["index.php", $conf["appName"]], ["quiz.php?id=".$quiz["id"], $quiz["name"]], "Confirmar importació de preguntes"]); ?>
    <h1>Confirmar importació de preguntes a <?=$quiz["name"]?></h1>
    <p>Aquestes són les preguntes que afegiràs al banc de preguntes. Estàs segur que les vols afegir?</p>
    <form action="doimportquestions.php" method="POST">
      <input type="hidden" name="id" value="<?=$quiz["id"]?>">
      <input type="hidden" name="info" value="<?=htmlspecialchars(json_encode($info))?>">
      <p><input type="submit" value="Sí"> | <a href="quiz.php?id=<?=$quiz["id"]?>">No</a></p>
    </form>
    <?php
    foreach ($info as $i => &$q) {
      echo "<hr><h3>Pregunta $i</h3><p><b>".$q["question"]."</b></p><ul>";
      foreach ($q["answers"] as &$a) {
        echo "<li>".$a."</li>";
      }
      echo "</ul><p>".$q["rightanswer"]."</p>";
    }
    ?>
</body>
</html>

