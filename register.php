<?php  //pagina para fazer o registro de usuario
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 


    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE username = ?");
    $stmt->execute([$username]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        $error = "O nome de usuário já está em uso.";
    } elseif ($username && $password) {
        $stmt = $conn->prepare("INSERT INTO Usuarios (username, password) VALUES (?, ?)");
        try {
            $stmt->execute([$username, $password]);
            $success = "Usuário registrado com sucesso!";
        } catch (PDOException $e) {
            $error = "Erro: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Usuário</h1>
        
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php elseif (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        
        <form method="POST">
            <label for="username">Nome de Usuário:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Registrar</button>
        </form>

        <p>Já possui uma conta? <a href="login.php">Faça login aqui</a></p>
    </div>
</body>
</html>
