<?php
require_once("core.php");

security::checkType(0);

if (!isset($_GET["id"])) {
  header("Location: home.php");
  exit();
}

$quiz = quiz::getQuiz((int)$_GET["id"]);

if ($quiz === false) {
  die("This quiz doesn't exist.");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([["home.php", $conf["appName"]], "Edita un qüestionari"]); ?>
    <h1>Edita un qüestionari</h1>
    <form action="doeditquiz.php" method="POST">
      <input type="hidden" name="id" value="<?=$quiz["id"]?>">
      <p>Nom: <input type="text" name="name" required value="<?=$quiz["name"]?>"></p>
      <p>Descripció:<br><textarea name="description" maxlength="1000"><?=$quiz["description"]?></textarea></p>
      <p><label for="visibility">Visibilitat del qüestionari: </label><select name="visibility" id="visibility"><?php foreach (quiz::$visibility as $i => $v) { echo '<option value="'.$i.'"'.($quiz["visibility"] == $i ? " selected" : "").'>'.$v.'</option>'; } ?></select></p>
      <p><label for="addition">Qui pot agregar preguntes: </label><select name="addition" id="addition"><?php foreach (quiz::$addition as $i => $v) { echo '<option value="'.$i.'"'.($quiz["addition"] == $i ? " selected" : "").'>'.$v.'</option>'; } ?></select></p>
      <p><input type="submit" value="Edita"></p>
    </form>
</body>
</html>

