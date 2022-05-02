<?php
include "/AppServ/www/task/config/db.php";

if (!$connection) {
  echo json_encode(array(
    "status" => 0,
    "msg" => "Couldn't connect to database.",
    "todos" => array()
  ));
} else {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['title']) && !empty($_POST['content'])) {
      $title = $connection->real_escape_string($_POST['title']);
      $content = $connection->real_escape_string($_POST['content']);
      $sql = "INSERT INTO `todos` (`title`, `content`) VALUES ( '$title', '$content');";
      $query = $connection->query($sql);
      $todos = array();
      if ($query) {
        $sqlData = "select * from `todos`;";
        $queryData = $connection->query($sqlData);
        while ($todo = $queryData->fetch_assoc()) {
          array_push($todos, $todo);
        }
        echo json_encode(array(
          "status" => 1,
          "msg" => "Successfully added.",
          "todos" => $todos
        ));
      } else {
        echo json_encode(array(
          "status" => 0,
          "msg" => "Oops, something went wrong.",
          "todos" => array()
        ));
      }
    } else {
      echo json_encode(array(
        "status" => 0,
        "msg" => "Title and content is required.",
        "todos" => array()
      ));
    }
  } else {
    echo json_encode(array(
      "status" => 0,
      "msg" => "Request method is not valid",
      "todos" => array()
    ));
  }
}
