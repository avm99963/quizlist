<?php
require_once("core.php");
require_once('lib/htmlpurifier/library/HTMLPurifier.auto.php');

if (!isset($_POST["id"]) || !isset($_POST["info"])) {
  header("Location: home.php");
  exit();
}

$qinfo = json_decode($_POST["info"], true);

if ($qinfo === null) {
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

$md5 = [];

foreach ($qinfo as $i => &$q) {
  $q["question"] = $purifier->purify($q["question"]);
  $pepper = preg_replace("/[^a-zA-Z0-9]/", "", strip_tags($q["question"]));
  $q["rightanswer"] = $purifier->purify($q["rightanswer"]);
  foreach ($q["answers"] as &$a) {
    $a = $purifier->purify($a);
    $a = preg_replace('/<img[^>]*src="[^>]*\/grade_[^>]*"[^>]*>/i', "", $a);
    $pepper .= preg_replace("/[^a-zA-Z0-9]/", "", strip_tags($a));
  }
  $md5[$i] = md5($pepper);
}

foreach ($qinfo as $i => &$q) {
  $infojson = json_encode($q);

  if (quiz::checkDuplicate($quiz["id"], $md5[$i])) {
    if (!db::addQuestion($quiz["id"], $infojson, $md5[$i])) {
      die("Hi ha hagut un problema afegint una pregunta.");
    }
  }
}

header("Location: quiz.php?id=".$quiz["id"]);
