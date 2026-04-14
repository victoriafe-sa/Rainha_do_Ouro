<?php
session_start();
include("../conectarbd.php"); // Ajuste o caminho conforme sua estrutura

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        echo "Por favor, preencha e-mail e senha.";
        exit;
    }

    $cartData = $_POST['cart_data'] ?? null;

    $sql = "SELECT id_clientes, email, senha, ativo FROM tb_clientes WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Erro na preparação da consulta: " . $conn->error;
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $cliente = $resultado->fetch_assoc();

        if ($cliente['ativo'] != 1) {
            echo "Conta inativa. Entre em contato com o salão.";
            exit;
        }

        // Compatibilidade hash
        $senha_valida = false;
        if (password_verify($senha, $cliente['senha'])) {
            $senha_valida = true;
        } elseif ($senha === $cliente['senha']) {
            $senha_valida = true;
            // Atualizar senha auto fallback
            $novaSenhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sqlUpdate = "UPDATE tb_clientes SET senha = ? WHERE id_clientes = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("si", $novaSenhaHash, $cliente['id_clientes']);
            $stmtUpdate->execute();
        }

        if ($senha_valida) {
            $_SESSION['id_cliente'] = $cliente['id_clientes'];
            $_SESSION['email_cliente'] = $cliente['email'];
            
            // Sincronizar carrinho
            if ($cartData) {
                $cart = json_decode($cartData, true);
                if (is_array($cart) && count($cart) > 0) {
                    $idCliente = $cliente['id_clientes'];
                    $sqlCarrinho = "SELECT id_carrinho FROM tb_carrinho WHERE tb_clientes_id_clientes = ? AND status = 'aberto' LIMIT 1";
                    $stmtCar = $conn->prepare($sqlCarrinho);
                    $stmtCar->bind_param("i", $idCliente);
                    $stmtCar->execute();
                    $resCar = $stmtCar->get_result();
                    $idCarrinho = null;
                    if ($resCar->num_rows > 0) {
                        $idCarrinho = $resCar->fetch_assoc()['id_carrinho'];
                    } else {
                        $sqlInsertCar = "INSERT INTO tb_carrinho (data_criacao, status, tb_clientes_id_clientes) VALUES (NOW(), 'aberto', ?)";
                        $stmtInsCar = $conn->prepare($sqlInsertCar);
                        $stmtInsCar->bind_param("i", $idCliente);
                        $stmtInsCar->execute();
                        $idCarrinho = $conn->insert_id;
                    }
                    
                    foreach ($cart as $item) {
                        $nomeProd = $item['name'];
                        $qtdProd = (int)$item['quantity'];
                        $precoProd = (float)$item['price'];
                        
                        $sqlProd = "SELECT id_produtos FROM tb_produtos WHERE nome = ? LIMIT 1";
                        $stmtProd = $conn->prepare($sqlProd);
                        $stmtProd->bind_param("s", $nomeProd);
                        $stmtProd->execute();
                        $resProd = $stmtProd->get_result();
                        if ($resProd->num_rows > 0) {
                            $idProduto = $resProd->fetch_assoc()['id_produtos'];
                            
                            $sqlCheckItem = "SELECT id_item, quantidade FROM tb_itens_carrinho WHERE id_carrinho = ? AND id_produto = ?";
                            $stmtCheck = $conn->prepare($sqlCheckItem);
                            $stmtCheck->bind_param("ii", $idCarrinho, $idProduto);
                            $stmtCheck->execute();
                            $resCheck = $stmtCheck->get_result();
                            
                            if ($resCheck->num_rows > 0) {
                                $rowItem = $resCheck->fetch_assoc();
                                $novaQtd = $rowItem['quantidade'] + $qtdProd;
                                $sqlUpItem = "UPDATE tb_itens_carrinho SET quantidade = ? WHERE id_item = ?";
                                $stmtUp = $conn->prepare($sqlUpItem);
                                $stmtUp->bind_param("ii", $novaQtd, $rowItem['id_item']);
                                $stmtUp->execute();
                            } else {
                                $sqlInsItem = "INSERT INTO tb_itens_carrinho (id_carrinho, id_produto, quantidade, preco_unit) VALUES (?, ?, ?, ?)";
                                $stmtInsItem = $conn->prepare($sqlInsItem);
                                $stmtInsItem->bind_param("iiid", $idCarrinho, $idProduto, $qtdProd, $precoProd);
                                $stmtInsItem->execute();
                            }
                        }
                    }
                    
                    echo "<script>localStorage.removeItem('cart');</script>";
                }
            }

            $redirect = $_POST['redirect'] ?? '../html/pagina_inicial.php';
            echo "<script>window.location.href = '$redirect';</script>";
            exit;
        } else {
            echo "<script>alert('Senha incorreta.'); window.location.href = '../html/user_login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Usuário não encontrado.'); window.location.href = '../html/user_login.php';</script>";
        exit;
    }
} else {
    echo "Método inválido.";
    exit;
}
?>