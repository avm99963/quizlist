<?php
require_once("core.php");
require_once('lib/htmlpurifier/library/HTMLPurifier.auto.php');

if (!isset($_GET["id"])) {
  header("Location: home.php");
  exit();
}

$quiz = quiz::getQuiz((int)$_GET["id"]);

if ($quiz === false) {
  die("This quiz doesn't exist.");
}

if ($quiz["visibility"] == quiz::PRIVATE_VIS) {
  security::checkType(0);
}

$questions = quiz::getQuestions($quiz["id"]);
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([["index.php", $conf["appName"]], $quiz["name"]]); ?>
    <h1><?=$quiz["name"]?></h1>
    <?php
    $showimport = ($quiz["addition"] == quiz::PUBLIC_ADD || security::isAllowed(security::ADMIN));
    $solutions = (isset($_GET["solutions"]) && $_GET["solutions"] == "show");
    ?>
    <p><?php if ($showimport) { ?><a href="importquestions.php?id=<?=$quiz["id"]?>">Afegeix preguntes</a> | <?php } ?><a href="quiz.php?id=<?=$quiz["id"].($solutions ? "" : "&solutions=show")?>"><?=($solutions ? "Amaga les solucions" : "Mostra les solucions")?></a></p>
    <p><b>Nota:</b> Per visualitzar correctament les imatges, és possible que necessiteu iniciar sessió al Campus Virtual i recarregar aquesta pàgina.</p>
    <?php
    foreach ($questions as $i => $q) {
      $qinfo = json_decode($q["info"], true);
      echo "<hr><h3>Pregunta ".($i + 1)."</h3><p><b>".$qinfo["question"]."</b></p><ul>";
      foreach ($qinfo["answers"] as $a) {
        echo "<li>".$a."</li>";
      }
      echo "</ul>";
      if ($solutions) {
        echo "<p>".$qinfo["rightanswer"]."</p>";
      }
    }
    ?>
</body>
</html>

