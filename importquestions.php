<?php
require_once("core.php");

if (!isset($_GET["id"])) {
  header("Location: home.php");
  exit();
}

$quiz = quiz::getQuiz((int)$_GET["id"]);

if ($quiz === false) {
  die("This quiz doesn't exist.");
}

if ($quiz["addition"] == quiz::PRIVATE_ADD) {
  security::checkType(0);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
    <style>
      #paste-area {
        display: block;
        margin: auto;
        background-color: #abcdef;
        min-height: 100px;
        max-width: 400px;
        width: 100%;
        border: dashed 1px black;
      }
    </style>
  </head>
  <body>
    <?php visual::breadcumb([["index.php", $conf["appName"]], ["quiz.php?id=".$quiz["id"], $quiz["name"]], "Importar preguntes"]); ?>
    <h1>Importar preguntes a <?=$quiz["name"]?></h1>
    <p>Hola! Per afegir les teves preguntes a aquest banc de preguntes, has de seguir els següents pasos:</p>
    <ol>
      <li>Un cop finalitzat el qüestionari, ves al Campus Virtual/Atenea, i obre la pàgina on surt el resum de totes les teves respostes. La URL serà semblant a aquesta: <code>https://campusvirtual2.ub.edu/mod/quiz/review.php?attempt={attempt_id}</code>.</li>
      <li>A aquella pàgina, prem la combinació de tecles <code>Ctrl+A</code> (<code>Cmd+a</code> a Mac) per seleccionar tot el text de la pàgina sencera, i prem <code>Ctrl+C</code> (<code>Cmd+C</code> a Mac) per copiar-lo tot.</li>
      <li>Fes clic en el quadrat blau d'aquí a baix, i enganxa el que has copiat (<code>Ctrl+V</code> o <code>Cmd+V</code> a Mac) per començar a importar les preguntes:</li>
    </ol>
    <div contenteditable id="paste-area"></div>
    <form method="POST" action="confirmimportquestions.php">
      <input type="hidden" name="id" value="<?=$quiz["id"]?>">
      <input type="hidden" name="info" id="info">
    </form>
    <script src="js/importquestions.js"></script>
</body>
</html>

