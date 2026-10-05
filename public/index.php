<?php
require_once '../config/database.php';

$stmt = $pdo->prepare("SELECT * FROM produtos ORDER BY id DESC");
$stmt->execute();
$produtos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Estoque - Produtos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #f3efef; padding: 8px; text-align: left; }
        th { background-color: #f5e9e9; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-add { background-color: #26eb54; color: #fffafa; }
        .btn-edit { background-color: #ffd147; color: #020101; }
        .btn-delete { background-color: #d40015; color: #fffbfb; }
    </style>
</head>
<body>
    <h1>Gestão de Estoque — Mercado</h1>
    <a href="cadastrar.php" class="btn btn-add">+ Cadastrar Novo Produto</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Qtd. Estoque</th>
                <th>Validade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($produtos) > 0): ?>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?= htmlspecialchars($produto['id']) ?></td>
                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                        <td><?= htmlspecialchars($produto['categoria']) ?></td>
                        <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($produto['quantidade']) ?></td>
                        <td><?= $produto['data_validade'] ? date('d/m/Y', strtotime($produto['data_validade'])) : 'N/A' ?></td>
                        <td>
                            <a href="editar.php?id=<?= $produto['id'] ?>" class="btn btn-edit">Editar</a>
                            <a href="deletar.php?id=<?= $produto['id'] ?>" class="btn btn-delete" onclick="return confirm('Deseja excluir este produto?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nenhum produto cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>