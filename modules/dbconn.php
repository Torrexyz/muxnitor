<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/modules/getenv.php");

$DBCONN_CONFIG = (object) [
  'server'   => $_ENV['DB__SERVER'],
  'name'     => $_ENV['DB__NAME'],
  'user'     => $_ENV['DB__USER'],
  'password' => $_ENV['DB__PASSWORD']
];

try {
  $DBCONN_DOOR = new PDO(
    "mysql:host={$DBCONN_CONFIG->server};dbname={$DBCONN_CONFIG->name}",
    $DBCONN_CONFIG->user,
    $DBCONN_CONFIG->password
  );
} catch (\PDOException $error) {
  die($error->getMessage());
}

?>
<?php

function dbcursor(string $statement, ?array $params = null, bool $checkexec = false) {
  global $DBCONN_DOOR;
  $QUERY = $DBCONN_DOOR->prepare($statement);
  $stmt_bool_response = $QUERY->execute($params);
  return $checkexec === false ? $QUERY : $stmt_bool_response;
}

?>
