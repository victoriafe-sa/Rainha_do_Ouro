<?php
header('Content-Type: application/json');
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data === null) {
    echo json_encode(['status' => 'error', 'message' => 'Dados inválidos', 'rawInput' => $input]);
} else {
    echo json_encode(['status' => 'success', 'data' => $data]);
}
