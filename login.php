<?php
// Prisijungimas prie duomenu bazes
$conn = mysqli_connect("localhost", "read_only_user", "Zuh0roJm9nC2QYzW4PRVoIABELTbd.NEu", "mysql");

// Prisijungimo patikra
if (!$conn) {
    die("Prisijungimo klaida: " . mysqli_connect_error());
}

// formos apdorojimas
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // vartotojo paieska
    $query = "SELECT password_hash FROM mysql.users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
		$hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $hashed_password = $user['password_hash'];

        // Slaptazodzio patikra
        if (password_verify($password, $hashed_password)) {
            echo "Sekmingas prisijungimas!";
        } else {
            echo "Neteisingas slaptazodis.";
        }
    } else {
        echo "Tokio vartotojo nera.";
    }
}

// Sujungimo uzdarymas
mysqli_close($conn);
?>
