<?php
// Conexão com banco
$conn = new mysqli("localhost", "usuario", "senha", "rainha_do_ouro");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

session_start();
$usuario_id = $_SESSION['usuario_id']; // Assumindo que você salvou o ID do usuário na sessão

// Se houve submissão
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $stmt = $conn->prepare("UPDATE usuarios SET nome=?, email=?, telefone=?, cep=?, logradouro=?, numero=?, bairro=?, cidade=?, estado=? WHERE id=?");
    $stmt->bind_param("sssssssssi", $nome, $email, $telefone, $cep, $logradouro, $numero, $bairro, $cidade, $estado, $usuario_id);

    if ($stmt->execute()) {
        header("Location: perfil_usuario.php?atualizado=1");
        exit();
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }
}

// Buscar dados do usuário
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
?>

<?php if (isset($_GET['atualizado'])): ?>
    <p style="color: green; font-weight: bold; padding: 10px; background-color: #e0ffe0; border: 1px solid #00aa00;">
        Informações atualizadas com sucesso!
    </p>
<?php endif; ?>
