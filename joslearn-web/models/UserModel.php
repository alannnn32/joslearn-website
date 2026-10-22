<?php
class UserModel {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Mencari pengguna berdasarkan Username / NIS / NIP
     *
     * @param string $username Username / NIS / NIP
     * @return array|false Data user jika ditemukan, atau false
     */
    public function findByIdentifier($username) {
        // Menggunakan kolom 'username' sesuai tabel database
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Mendaftarkan pengguna baru
     *
     * @param string $username Username / NIS / NIP
     * @param string $nama_lengkap Nama lengkap user
     * @param string $email Email user
     * @param string $password Password yang belum di-hash
     * @param string $role Role user ('siswa', 'guru', 'admin')
     * @return boolean
     */
    public function register($username, $nama_lengkap, $email, $password, $role = 'siswa') {
        // Menggunakan kolom 'username' dan 'password'
        $query = "INSERT INTO " . $this->table_name . " (username, nama_lengkap, email, password, role) 
                  VALUES (:username, :nama_lengkap, :email, :password, :role)";

        $stmt = $this->conn->prepare($query);

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $username     = htmlspecialchars(strip_tags($username));
        $nama_lengkap = htmlspecialchars(strip_tags($nama_lengkap));
        $email        = htmlspecialchars(strip_tags($email));
        $role         = htmlspecialchars(strip_tags($role));

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':nama_lengkap', $nama_lengkap);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>