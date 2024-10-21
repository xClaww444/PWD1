<?php
// Koneksi ke database (sesuaikan dengan konfigurasi Anda)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registrasi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses data formulir jika tombol submit ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];

    // Validasi data (Anda bisa menambahkan validasi lebih lanjut)
    if ($password !== $repassword) {
        echo "Password tidak sama!";
    } else {
        // Hapus enkripsi password
        // Simpan password dalam bentuk teks biasa
        // Persiapkan query SQL
        $sql = "INSERT INTO daftar (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);

        // Eksekusi query
        if ($stmt->execute()) {
            // Arahkan user ke page login
            header("Location: login.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulir Signup</title>
</head>
<body>
    <h2>Formulir Signup</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        Retype Password: <input type="password" name="repassword" required><br>
        <input type="submit" value="Daftar">
    </form>
    <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
</body>
</html>