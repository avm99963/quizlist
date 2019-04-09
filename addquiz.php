<?php
require_once("core.php");

security::checkType(0);
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([["home.php", $conf["appName"]], "Afegir un qüestionari"]); ?>
    <h1>Afegir un qüestionari</h1>
    <form action="doaddquiz.php" method="POST">
      <p>Nom: <input type="text" name="name" required></p>
      <p>Descripció:<br><textarea name="description" maxlength="1000"></textarea></p>
      <p><label for="visibility">Visibilitat del qüestionari: </label><select name="visibility" id="visibility"><?php foreach (quiz::$visibility as $i => $v) { echo '<option value="'.$i.'">'.$v.'</option>'; } ?></select></p>
      <p><label for="addition">Qui pot agregar preguntes: </label><select name="addition" id="addition"><?php foreach (quiz::$addition as $i => $v) { echo '<option value="'.$i.'">'.$v.'</option>'; } ?></select></p>
      <p><input type="submit" value="Afegeix"></p>
    </form>
</body>
</html>

