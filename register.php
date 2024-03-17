<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

//  Prisijungimas prie duomenu bazes
$conn = mysqli_connect("localhost", "write_only_user", "OkldG6cTAsBizSf4c58VwQk1ttOBzjq6", "mysql");

// Prisijungimo patikra
if (!$conn) {
    die("Prisijungimo klaida: " . mysqli_connect_error());
}

// Formos apdorojimas
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Slaptazodzio hesavimas
//    $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Irasymas i duomenu baze
    $query = "INSERT INTO users (username, password_hash) VALUES ('$username', '$hashed_password')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Vartotojas uzregistruotas!";
    } else {
        echo "Registracijos klaida: " . mysqli_error($conn);
    }
}

// Sujungimo uzdarymas
mysqli_close($conn);
?>
