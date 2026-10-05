<?php
require_once '../config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
$stmt->execute([':id' => $id]);
$produto = $stmt->fetch();

if (!$produto) {
    header('Location: index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome          = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $categoria     = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $descricao     = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $preco         = filter_input(INPUT_POST, 'preco', FILTER_VALIDATE_FLOAT);
    $quantidade    = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
    $data_validade = $_POST['data_validade'] ?? null;

    if (!$nome || !$categoria || $preco === false || $quantidade === false) {
        $erro = 'Por favor, preencha todos os campos obrigatórios corretamente.';
    } else {
        $sql = "UPDATE produtos 
                SET nome = :nome, categoria = :categoria, descricao = :descricao, 
                    preco = :preco, quantidade = :quantidade, data_validade = :data_validade 
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $sucesso = $stmt->execute([
            ':nome'          => $nome,
            ':categoria'     => $categoria,
            ':descricao'     => $descricao,
            ':preco'         => $preco,
            ':quantidade'    => $quantidade,
            ':data_validade' => !empty($data_validade) ? $data_validade : null,
            ':id'            => $id,
        ]);

        if ($sucesso) {
            header('Location: index.php');
            exit;
        } else {
            $erro = 'Erro ao atualizar produto.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
</head>
<body>
    