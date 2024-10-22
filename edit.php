<?php     //aqui e a pagina para eu poder editar.
include 'db.php';


$peca = null;
if (isset($_GET['numero'])) {
    $numero = $_GET['numero'];
    $stmt = $conn->prepare("SELECT * FROM Pecas WHERE numero = ?");
    $stmt->execute([$numero]);
    $peca = $stmt->fetch(PDO::FETCH_ASSOC);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'];
    $peso = $_POST['peso'];
    $cor = $_POST['cor'];

    if ($numero && $peso && $cor) {
        $stmt = $conn->prepare("UPDATE Pecas SET peso = ?, cor = ? WHERE numero = ?");
        $stmt->execute([$peso, $cor, $numero]);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Peça</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Alterar Peça</h1>
        
        <?php if ($peca): ?>
        <form method="POST">
            <input type="hidden" name="numero" value="<?php echo htmlspecialchars($peca['numero']); ?>">
            
            <label for="peso">Peso:</label>
            <input type="number" step="0.01" id="peso" name="peso" value="<?php echo htmlspecialchars($peca['peso']); ?>" required>
            
            <label for="cor">Cor:</label>
            <input type="text" id="cor" name="cor" value="<?php echo htmlspecialchars($peca['cor']); ?>" required>
            
            <button type="submit">Atualizar Peça</button>
        </form>
        <?php else: ?>
            <p>Peça não encontrada.</p>
        <?php endif; ?>
        
        <button onclick="window.location.href='index.php'">Voltar</button>
    </div>
</body>
</html>
