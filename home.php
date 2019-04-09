<?php
require_once("core.php");

security::check();
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([$conf["appName"]]); ?>
    <?php
    if (security::userType() == 0) {
      echo '<a href="addquiz.php">Afegeix un qüestionari</a> | <a href="users.php">Gestiona els usuaris</a>';
    }
    ?>
    <ul>
      <?php
      $quizes = quiz::getQuizzes();

      if (count($quizes)) {
        foreach ($quizes as $q) {
          echo "<li><a href='quiz.php?id=".$q["id"]."'>".$q["name"]."</a> (<a href='editquiz.php?id=".$q["id"]."'>modifica</a>, <a href='importquestions.php?id=".$q["id"]."'>afegeix preguntes</a>)</li>";
        }
      } else {
        echo "No hi ha cap qüestionari configurat encara.";
      }
      ?>
    </ul>
  </body>
</html>

