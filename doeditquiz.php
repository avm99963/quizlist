<?php
require_once("core.php");

security::checkType(0);

if (!isset($_POST["id"]) || !isset($_POST["name"]) || empty($_POST["name"]) || !isset($_POST["visibility"]) || !isset($_POST["addition"])) {
  header("Location: home.php?msg=empty");
  exit();
}

$quiz = quiz::getQuiz((int)$_POST["id"]);

if ($quiz === false) {
  header("Location: home.php");
  exit();
}

if (db::editQuiz($quiz["id"], $_POST["name"], (isset($_POST["description"]) ? $_POST["description"] : ""), $_POST["visibility"], $_POST["addition"])) {
  header("Location: home.php?msg=quizedited");
  exit();
} else {
  echo "Hi ha hagut un error editant el qüestionari.";
}
