<?php //aqui e a minha index.php
session_start();
include 'db.php';

// Adicionar nova peça
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'];
    $peso = $_POST['peso'];
    $cor = $_POST['cor'];

    if ($numero && $peso && $cor) {
        $stmt = $conn->prepare("INSERT INTO Pecas (numero, peso, cor) VALUES (?, ?, ?)");
        $stmt->execute([$numero, $peso, $cor]);
    }
}

// Recuperar peças
$stmt = $conn->query("SELECT * FROM Pecas");
$pecas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Indústria</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Peças</h1>
        
        <form method="POST">
            <label for="numero">Número:</label>
            <input type="number" id="numero" name="numero" required>
            
            <label for="peso">Peso:</label>
            <input type="number" step="0.01" id="peso" name="peso" required>
            
            <label for="cor">Cor:</label>
            <input type="text" id="cor" name="cor" required>
            
            <button type="submit">Adicionar Peça</button>
        </form>

        <h2>Lista de Peças</h2>
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Peso</th>
                    <th>Cor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pecas as $peca): ?>
                <tr>
                    <td><?php echo htmlspecialchars($peca['numero']); ?></td>
                    <td><?php echo htmlspecialchars($peca['peso']); ?></td>
                    <td><?php echo htmlspecialchars($peca['cor']); ?></td>
                    <td>
                        <a href="edit.php?numero=<?php echo htmlspecialchars($peca['numero']); ?>">Alterar</a>
                        <a href="delete.php?numero=<?php echo htmlspecialchars($peca['numero']); ?>" onclick="return confirm('Tem certeza que deseja excluir esta peça?');">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
