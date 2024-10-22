<?php  //pagina de delete.
include 'db.php';

if (isset($_GET['numero'])) {
    $numero = $_GET['numero'];
    $stmt = $conn->prepare("DELETE FROM Pecas WHERE numero = ?");
    $stmt->execute([$numero]);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Peça</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Excluir Peça</h1>
        <p>Peça excluída com sucesso!</p>
        <button onclick="window.location.href='index.php'">Voltar</button>
    </div>
</body>
</html>
