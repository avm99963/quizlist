<?php
require_once("core.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Install</title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <h1><?=$conf["appName"]?> install</h1>
    <?php
    if (!isset($_POST["username"])) {
      ?>
      <form method="post" action="install.php">
        <p>Enther the details for the first admin:</p>
        <p>Username: <input type="text" name="username"></p>
        <p>Password: <input type="password" name="password"></p>
        <p><input type="submit" value="Install"></p>
      </form>
      <?php
    } else {
      if (!isset($_POST["username"]) || !isset($_POST["password"]) || empty($_POST["username"]) || empty($_POST["password"]))

      $sql = array();

      $sql["users"] = "CREATE TABLE users
        (
          id INT(13) NOT NULL AUTO_INCREMENT,
      	  PRIMARY KEY(id),
      	  username VARCHAR(50) NOT NULL UNIQUE,
          password VARCHAR(255) NOT NULL,
          type INT(2)
        )";

      $sql["quizzes"] = "CREATE TABLE quizzes
	(
	  id INT(13) NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(id),
          name VARCHAR(50),
          description VARCHAR(1000),
          visibility INT(2),
          addition INT(2)
        )";

      $sql["questions"] = "CREATE TABLE questions
        (
          id INT(13) NOT NULL AUTO_INCREMENT,
          PRIMARY KEY(id),
          quiz INT(13),
          info TEXT,
          titlesum VARCHAR(32)
        )";

      foreach ($sql as $key => $query) {
        if (!mysqli_query($con, $query)) {
          die("<div class='alert danger'>Ha ocurrido un error inesperado al crear la tabla ".$key.": ".mysqli_error($con).".</div>");
        }
      }

      $username = htmlspecialchars(mysqli_real_escape_string($con, $_POST['username']));
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $sql6 = "INSERT INTO users (username, password, type) VALUES ('".$username."', '".$password."', 0)";
      if (!mysqli_query($con,$sql6)) {
        die("<div class='alert danger'>Ha ocurrido un error inesperado al crear el usuario administrador: ".mysqli_error($con).".</div>");
      }
      ?>
      <p><a href="index.php">Go log in</a><p>
      <?php
    }
    ?>
  </body>
</html>
