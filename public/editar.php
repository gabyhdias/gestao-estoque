<?php
require_once '../config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

// Buscar produto existente
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
    <h1>Editar Produto</h1>
    <?php if ($erro): ?>
        <p style="color: red;"><?= $erro ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nome:*</label><br>
        <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required><br><br>

        <label>Categoria:*</label><br>
        <input type="text" name="categoria" value="<?= htmlspecialchars($produto['categoria']) ?>" required><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao"><?= htmlspecialchars($produto['descricao']) ?></textarea><br><br>

        <label>Preço (R$):*</label><br>
        <input type="number" step="0.01" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>" required><br><br>

        <label>Quantidade em Estoque:*</label><br>
        <input type="number" name="quantidade" value="<?= htmlspecialchars($produto['quantidade']) ?>" required><br><br>

        <label>Data de Validade:</label><br>
        <input type="date" name="data_validade" value="<?= $produto['data_validade'] ?>"><br><br>

        <button type="submit">Atualizar</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>