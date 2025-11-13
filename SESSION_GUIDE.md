# Session Management - Dokumentasi

## Struktur Session

Setelah login berhasil, session menyimpan data dalam struktur berikut:

```php
$_SESSION["user"] = [
    "id" => 1,              // User ID
    "username" => "admin",  // Username
    "role" => "admin"       // Role (admin/personil)
];
```

**HANYA** gunakan struktur di atas. Tidak ada `$_SESSION["user_id"]` atau `$_SESSION["role"]` terpisah.

## Cara Menggunakan Session

### 1. Di Controller

```php
use App\Helpers\SessionHelper;

class DashboardController extends Controller
{
    public function index()
    {
        // Mendapatkan data user
        $userId = SessionHelper::getUserId();
        $username = SessionHelper::getUsername();
        $role = SessionHelper::getRole();
        $user = SessionHelper::getUser(); // Semua data
        
        // Cek role
        if (SessionHelper::isAdmin()) {
            // Admin only logic
        }
        
        $data = [
            "user" => $user,
            "username" => $username
        ];
        
        $this->render("dashboard/index", $data);
    }
}
```

### 2. Di Middleware

Semua middleware menggunakan struktur session yang konsisten:

```php
// AuthMiddleware - Cek apakah user login
if (!isset($_SESSION["user"]["id"])) {
    // redirect
}

// AdminMiddleware - Cek role admin
if (!isset($_SESSION["user"]["role"]) || $_SESSION["user"]["role"] !== "admin") {
    // redirect
}

// PersonilMiddleware - Cek role personil atau admin
if (!isset($_SESSION["user"]["role"]) || 
    ($_SESSION["user"]["role"] !== "personil" && $_SESSION["user"]["role"] !== "admin")) {
    // redirect
}
```

### 3. Di View (Optional, gunakan dengan hati-hati)

Lebih baik pass data dari controller, tapi jika perlu akses langsung:

```php
<?php if (isset($_SESSION["user"])): ?>
    <p>Halo, <?= htmlspecialchars($_SESSION["user"]["username"]) ?></p>
    
    <?php if ($_SESSION["user"]["role"] === "admin"): ?>
        <a href="/admin/dashboard">Admin Panel</a>
    <?php endif; ?>
<?php endif; ?>
```

### 4. Logout

```php
use App\Helpers\SessionHelper;

class LogoutController extends Controller
{
    public function logout()
    {
        SessionHelper::destroy();
        header("Location: /login");
        exit();
    }
}
```

### 5. Flash Messages (Bonus)

```php
// Set flash message
SessionHelper::setFlash("success", "Data berhasil disimpan!");
SessionHelper::setFlash("error", "Terjadi kesalahan!");

// Get flash message (otomatis terhapus setelah diambil)
$success = SessionHelper::getFlash("success");
$error = SessionHelper::getFlash("error");
```

## File Yang Sudah Diupdate

1. ✅ `src/Models/UserModel.php` - Method `validateCredentials()` baru
2. ✅ `src/Controllers/LoginController.php` - Simpan session lengkap
3. ✅ `src/Middlewares/AuthMiddleware.php` - Support struktur baru
4. ✅ `src/Middlewares/AdminMiddleware.php` - Support struktur baru
5. ✅ `src/Middlewares/PersonilMiddleware.php` - Support struktur baru
6. ✅ `src/Middlewares/GuestMiddleware.php` - Support struktur baru
7. ✅ `src/Helpers/SessionHelper.php` - Utility helper baru

## Keuntungan Implementasi Ini

1. **Performa**: Data di memory, tidak perlu query database berulang
2. **Security**: Password hash tidak disimpan di session
3. **Konsistensi**: Satu struktur session untuk semua kode
4. **Clean Code**: Tidak ada backward compatibility yang membingungkan
5. **Authorization**: Cek role cepat tanpa database query
6. **Audit Trail**: Punya user_id untuk logging activity

## Best Practices

✅ **DO**:
- Gunakan `SessionHelper` untuk akses session
- Simpan data yang sering dipakai (id, username, role)
- Validasi session di middleware
- Pass data dari controller ke view
- Gunakan struktur `$_SESSION["user"]` yang konsisten

❌ **DON'T**:
- Jangan simpan password/password_hash di session
- Jangan simpan data sensitif (credit card, dll)
- Jangan simpan data yang jarang dipakai
- Jangan gunakan `$_SESSION["user_id"]` atau `$_SESSION["role"]` terpisah
- Jangan akses `$_SESSION` langsung jika bisa pakai helper

## Testing

Test dengan skenario berikut:

1. Login sebagai admin → Cek `$_SESSION["user"]["role"]` = "admin"
2. Login sebagai personil → Cek `$_SESSION["user"]["role"]` = "personil"
3. Akses halaman dengan middleware → Harus bisa melewati cek
4. Logout → Session harus terhapus
5. Akses halaman protected setelah logout → Redirect ke login
