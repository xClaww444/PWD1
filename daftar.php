<?php
// Koneksi ke database (sesuaikan dengan konfigurasi Anda)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "peserta";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses data formulir jika tombol submit ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $nama = $_POST["nama"];
    $institusi = $_POST["institusi"];
    $negara = $_POST["negara"];
    $alamat = $_POST["alamat"];

    // Validasi data (Anda bisa menambahkan validasi lebih lanjut)
    if (empty($email) || empty($nama) || empty($institusi) || empty($negara) || empty($alamat)) {
        echo "Semua field harus diisi!";
    } else {
        // Persiapkan query SQL
        $sql = "INSERT INTO daftar (email, nama, institusi, negara, alamat) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $email, $nama, $institusi, $negara, $alamat);

        // Eksekusi query
        if ($stmt->execute()) {
            // Redirect ke daftar-peserta.php setelah pendaftaran berhasil
            header("Location: daftar-peserta.php");
            exit();
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
    <title>Formulir Pendaftaran</title>
    <style>
        .btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <h2>Formulir Pendaftaran</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Email: <input type="email" name="email" required><br>
        Nama: <input type="text" name="nama" required><br>
        Institusi: <input type="text" name="institusi" required><br>
        Negara: <input type="text" name="negara" required><br>
        Alamat: <textarea name="alamat" required></textarea><br>
        <input type="submit" value="Daftar">
    </form>
    <p>
        <a href="login.php" class="btn">admin? Login disini</a>
        <a href="daftar-peserta.php" class="btn">Lihat Peserta</a>
    </p>
</body>
</html>