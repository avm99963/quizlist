<?php
require_once("core.php");

security::checkType(0);

if (!isset($_POST["name"]) || empty($_POST["name"]) || !isset($_POST["visibility"]) || !isset($_POST["addition"])) {
  header("Location: addquiz.php?msg=empty");
  exit();
}

if (db::addQuiz($_POST["name"], (isset($_POST["description"]) ? $_POST["description"] : ""), $_POST["visibility"], $_POST["addition"])) {
  header("Location: home.php?msg=quizadded");
  exit();
} else {
  echo "Hi ha hagut un error guardant el qüestionari.";
}
