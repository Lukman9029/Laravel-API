## 🧩 Laravel API - User Management

Project ini merupakan contoh sederhana RESTful API menggunakan Laravel 12 + Sanctum untuk autentikasi dan manajemen data pengguna (User Management).
Didesain untuk kebutuhan testing API seperti register, login, get user, update, dan delete user.

# 🚀 Fitur Utama
- 🔐 Autentikasi Sanctum (Login & Register dengan token)
- 👤 Manajemen User
-- Get list semua user
-- Get user berdasarkan ID
-- Update user
-- Delete user
- ⚙️ Validasi otomatis (Laravel Validation)
- 🔄 Hash Password menggunakan bcrypt
- 🧱 Struktur modular untuk pengembangan API lanjutan

# 🛠️ Teknologi yang Digunakan
| Komponen     | Versi / Teknologi        |
| ------------ | ------------------------ |
| Framework    | Laravel 12               |
| Auth         | Laravel Sanctum          |
| Database     | MySQL / MariaDB          |
| Server       | PHP 8.2+                 |
| Tool Testing | Postman / Thunder Client |

# 🔑 Endpoint API
| Method | Endpoint          | Deskripsi                 | Autentikasi |
| ------ | ----------------- | ------------------------- | ----------- |
| POST   | `/api/register`   | Register user baru        | ❌           |
| POST   | `/api/login`      | Login dan generate token  | ❌           |
| GET    | `/api/profile`    | Ambil data user pribadi   | ✅           |
| PUT    | `/api/update/`    | Update data user pribadi  | ✅           |
| GET    | `/api/user`       | Ambil semua user          | ✅✅        |
| POST   | `/api/user`       | Buat user baru            | ✅✅        |
| GET    | `/api/user/{id}`  | Ambil user berdasarkan ID | ✅✅        |
| PUT    | `/api/user/{id}`  | Update data user          | ✅✅        |
| DELETE | `/api/user/{id}`  | Hapus user                | ✅✅        |
| POST   | `/api/logout`     | Logout user & hapus token | ✅           |

✅ = membutuhkan Bearer Token (Sanctum)
✅✅ = membutuhkan role admin

