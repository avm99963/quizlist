<?php
class quiz {
  const PUBLIC_VIS = 0;
  const PRIVATE_VIS = 1;

  const PUBLIC_ADD = 0;
  const PRIVATE_ADD = 1;

  public static $visibility = [
    0 => "Públic",
    1 => "Ocult"
  ];

  public static $addition = [
    0 => "Tothom",
    1 => "Només administradors"
  ];

  public static function getQuizzes() {
    global $con;

    $query = mysqli_query($con, "SELECT * FROM quizzes");

    if (!mysqli_num_rows($query)) {
      return [];
    }

    $r = array();

    while ($row = mysqli_fetch_assoc($query)) {
      $r[] = $row;
    }

    return $r;
  }

  public static function getQuiz($id) {
    global $con;

    $query = mysqli_query($con, "SELECT * FROM quizzes WHERE id = ".(int)$id);

    if (!mysqli_num_rows($query)) {
      return false;
    }

    return mysqli_fetch_assoc($query);
  }

  public static function checkDuplicate($quiz, $md5) {
    global $con;

    $md5 = db::escape($md5, false);

    $query = mysqli_query($con, "SELECT id FROM questions WHERE titlesum = '".$md5."' AND quiz = ".(int)$quiz);

    if (mysqli_num_rows($query) > 0) {
      var_dump(mysqli_fetch_assoc($query));
    }
    return (mysqli_num_rows($query) === 0);
  }

  public static function getQuestions($id) {
    global $con;

    $query = mysqli_query($con, "SELECT * FROM questions WHERE quiz = ".(int)$id);

    if (!mysqli_num_rows($query)) {
      return [];
    }

    $r = [];

    while ($row = mysqli_fetch_assoc($query)) {
      $r[] = $row;
    }

    return $r;
  }
}
