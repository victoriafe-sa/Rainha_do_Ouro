<?php
include("../conectarbd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Normaliza email
    $email = strtolower(trim($_POST['email'] ?? ''));

    // Remove tudo que não é número do telefone
    $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');

    // Normaliza data para formato YYYY-MM-DD
    $data_nascimento = trim($_POST['data_nascimento'] ?? '');
    if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $data_nascimento)) {
        [$dia, $mes, $ano] = explode('/', $data_nascimento);
        $data_nascimento = "$ano-$mes-$dia";
    }

    if (empty($email) || empty($telefone) || empty($data_nascimento)) {
        echo "Preencha todos os campos.";
        exit;
    }

    // Consulta com normalização no banco também
    $sql = "SELECT id_clientes FROM tb_clientes 
            WHERE LOWER(TRIM(email)) = ? 
              AND REPLACE(REPLACE(REPLACE(REPLACE(telefone, '(', ''), ')', ''), '-', ''), ' ', '') = ?
              AND DATE(data_nascimento) = ?
            LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Erro interno.";
        exit;
    }

    $stmt->bind_param("sss", $email, $telefone, $data_nascimento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "ok";
    } else {
        echo "Dados não conferem.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método inválido.";
}
?>
