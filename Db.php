<?php //aqui e o meu banco de dados

$database = 'industriadb.sqlite';

try {
    $conn = new PDO("sqlite:$database");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    $conn->exec("CREATE TABLE IF NOT EXISTS Pecas (
        numero INTEGER PRIMARY KEY,                         
        peso REAL,                                         
        cor TEXT                                         
    )");

    $conn->exec("CREATE TABLE IF NOT EXISTS Usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    )");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
