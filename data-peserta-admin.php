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

// Proses penghapusan peserta jika ID diterima
if (isset($_GET['delete_email'])) {
    $delete_id = $_GET['delete_email'];
    $delete_sql = "DELETE FROM daftar WHERE email = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $delete_id);
    $delete_stmt->execute();
    $delete_stmt->close();
}

// Ambil data peserta dari database
$sql = "SELECT email, nama, institusi, negara, alamat FROM daftar";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Peserta</title>
</head>
<body>
    <h2>Daftar Peserta</h2>
    <?php
    if ($result->num_rows > 0) {
        // Tampilkan data dalam tabel
        echo "<table border='1'>
                <tr>
                    <th>Email</th>
                    <th>Nama</th>
                    <th>Institusi</th>
                    <th>Negara</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>";
        
        // Output data setiap baris
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["email"]) . "</td>
                    <td>" . htmlspecialchars($row["nama"]) . "</td>
                    <td>" . htmlspecialchars($row["institusi"]) . "</td>
                    <td>" . htmlspecialchars($row["negara"]) . "</td>
                    <td>" . htmlspecialchars($row["alamat"]) . "</td>
                    <td>
                        <a href='?delete_id=" . $row["email"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus peserta ini?\")'>Hapus</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Tidak ada peserta yang terdaftar.";
    }
    ?>

    <p><a href="daftar.php">Daftar Peserta Baru</a></p>
    <p><a href="login.php">Admin? Login disini</a></p>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>