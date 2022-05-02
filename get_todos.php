<?php
include "/AppServ/www/task/config/db.php";
if (!$connection) {
  echo json_encode(array(
    "status" => 0,
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
        "status" => 1,
        "msg" => count($todos) . " todos are shown.",
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
      "msg" => "Request method is not valid",
      "todos" => array()
    ));
  }
}
