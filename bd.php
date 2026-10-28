<?php
$host     = "localhost";
$dbname   = "datos_registro";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $email    = trim($_POST['email']);
        $pass_raw = $_POST['passwords'];

        $tabla_solicitada = $_POST['usuarios'] ?? '';

        if (!empty($email) && !empty($pass_raw)) {
            
            $password_hashed = password_hash($pass_raw, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (email, passwords) VALUES (:email, :passwords)";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':email'    => $email,
                ':passwords' => $password_hashed
            ]);

            echo "¡Usuario registrado y contraseña guardada de forma segura!";
            
        } else {
            echo "Por favor, completa todos los campos.";
        }
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?>