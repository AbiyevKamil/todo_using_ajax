<?php
include "/AppServ/www/task/config/db.php";
if (!$connection) {
  echo json_encode(array(
    "msg" => "Couldn't connect to database.",
    "todos" => array()
  ));
} else {
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sqlData = "select * from `todos`;";
    $queryData = $connection->query($sqlData);
    $todos = array();
    if ($queryData) {
      while ($todo = $queryData->fetch_assoc()) {
        array_push($todos, $todo);
      }
      echo json_encode(array(
        "msg" => count($todos) . " todos are shown.",
        "todos" => $todos
      ));
    } else {
      echo json_encode(array(
        "msg" => "Oops, something went wrong.",
        "todos" => array()
      ));
    }
  } else {
    echo json_encode(array(
      "msg" => "Request method is not valid",
      "todos" => array()
    ));
  }
}
