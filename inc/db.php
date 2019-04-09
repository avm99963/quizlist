<?php
class db {
  public static function escape($str, $html=true) {
    global $con;

    return ($html ? mysqli_real_escape_string($con, htmlspecialchars($str)) : mysqli_real_escape_string($con, $str));
  }

  public static function addQuiz($name, $description, $visibility, $addition) {
    global $con;

    $visibility = (int)$visibility;
    $addition = (int)$addition;

    if ($visibility >= count(quiz::$visibility) || $visibility < 0) {
      return false;
    }

    if ($addition >= count(quiz::$addition) || $addition < 0) {
      return false;
    }

    $name = self::escape($name);
    $description = self::escape($description);

    return mysqli_query($con, "INSERT INTO quizzes (name, description, visibility, addition) VALUES ('".$name."', '".$description."', ".$visibility.", ".$addition.")");
  }

  public static function editQuiz($id, $name, $description, $visibility, $addition) {
    global $con;

    $id = (int)$id;
    $visibility = (int)$visibility;
    $addition = (int)$addition;

    if ($visibility >= count(quiz::$visibility) || $visibility < 0) {
      return false;
    }

    if ($addition >= count(quiz::$addition) || $addition < 0) {
      return false;
    }

    $name = self::escape($name);
    $description = self::escape($description);

    return mysqli_query($con, "UPDATE quizzes SET name = '".$name."', description = '".$description."', visibility = ".$visibility.", addition = ".$addition." WHERE id = ".$id." LIMIT 1");
  }

  public static function getUsers() {
    global $con, $conf;

    $query = mysqli_query($con, "SELECT id, username, type FROM users");

    $usuaris = [];

    while ($row = mysqli_fetch_assoc($query)) {
      $usuaris[] = $row;
    }

    return $usuaris;
  }

  public static function addUser($username, $password, $type) {
    global $con;

    if ($type > 2 || $type < 0) {
      return false;
    }

    $u = self::escape($username, false);
    $p = password_hash($password, PASSWORD_DEFAULT);
    $t = (int)$type;

    return mysqli_query($con, "INSERT INTO users (username, password, type) VALUES ('".$u."', '".$p."', ".$t.")");
  }

  public static function addQuestion($quiz, $info, $md5) {
    global $con;

    $quiz = (int)$quiz;
    $info = self::escape($info, false);
    $md5 = self::escape($md5, false);

    return mysqli_query($con, "INSERT INTO questions (quiz, info, titlesum) VALUES (".$quiz.", '".$info."', '".$md5."')");
  }
}
