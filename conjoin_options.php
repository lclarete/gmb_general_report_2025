<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204);
  exit;
}

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data) {
  http_response_code(400);
  echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
  exit;
}

file_put_contents("conjoin_log.ndjson", json_encode([
  "received_at" => date("c"),
  "ip" => $_SERVER['REMOTE_ADDR'] ?? null,
  "payload" => $data
]) . "\n", FILE_APPEND);

echo json_encode(["status" => "ok"]);
?>
