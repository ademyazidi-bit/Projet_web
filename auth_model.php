<?php
// auth_model.php — Member 1
// Uses table: utilisateurs (id, nom, email, mot_de_passe, cree_le)

require_once 'bd.php';

function registerUser($name, $email, $password) {
    global $pdo;

    // Check if email already taken
    $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        return 'Cet email est déjà utilisé.';
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare(
        "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)"
    );
    $stmt->execute([
        ':nom'          => $name,
        ':email'        => $email,
        ':mot_de_passe' => $hashed
    ]);

    return true;
}

function loginUser($email, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        // Return normalized keys so the rest of the app works
        return [
            'id'    => $user['id'],
            'name'  => $user['nom'],
            'email' => $user['email']
        ];
    }

    return false;
}
?>
