<div align="center">
  <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" width="100" alt="PHP Logo">
  <img src="https://www.svgrepo.com/show/353579/codeigniter.svg" width="100" alt="CodeIgniter 4 Logo">
</div>

## 📖  Praktikum 4-6


## 👤 Profil Mahasiswa

| Atribut         | Keterangan            |
| --------------- | --------------------- |
| *Nama*        | Afryan Dhinar Restu Panggih    |
| *NIM*         | 312310467          |
| *Kelas*       | TI.23.A.5             |
| *Mata Kuliah* | Pemrograman Website 2 |

---


## 1. Membuat Tabel Login
Membuat tabel database dengan nama Tabel Login  
![Screenshot 2025-07-01 135630](https://github.com/user-attachments/assets/ad023684-766d-4857-91e8-ccaafbdde537)

## 2. Membuat Tabel User
Selanjutnya membuat Tabel User di dalam database yang bernama Tabel Login  
![Screenshot 2025-07-01 135946](https://github.com/user-attachments/assets/66c5597e-acc4-4d78-b6aa-cad16ca127f9)

## 3. Membuat Model User
Selanjutnya adalah membuat Model untuk memproses data Login. Buat file baru pada direktori app/Models dengan nama UserModel.php  
![Screenshot 2025-07-01 140241](https://github.com/user-attachments/assets/14d65c33-f04f-4c59-9eed-585c27c86638)

## 4. Membuat Controller User
Buat Controller baru dengan nama User.php pada direktori app/Controllers. Kemudian tambahkan method index() untuk menanmpilkan daftar user, dan method login() untuk proses login.  
```
<?php
namespace App\Controllers;
use CodeIgniter\Model;
class User extends BaseController
{

    public function index()
    {
        $title = 'Daftar User';
        $model = new UserModel();
        $users = $model->findAll();
        return view('user/index', compact('users', 'title'));
    }

    public function login()
{
    helper(['form']);
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    if (!$email || !$password) {
        return view('/user/login');
    }

    $session = session();
    $db = \Config\Database::connect();
    $builder = $db->table('user');
    $login = $builder->where('useremail', $email)->get()->getRowArray();

    if ($login) {
        $pass = $login['userpassword'];
        if (trim($password) === trim($pass)) {
            $login_data = [
                'user_id'    => $login['id'],
                'user_name'  => $login['username'],
                'user_email' => $login['useremail'],
                'logged_in'  => true,
            ];
            $session->set($login_data);
            return redirect()->to('/admin/artikel');
        } else {
            $session->setFlashdata("flash_msg", "Password salah.");
            return redirect()->to('/user/login');
        }
    } else {
        $session->setFlashdata("flash_msg", "Email tidak ditemukan.");
        return redirect()->to('/user/login');
    }
}
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/user/login');
    }
}
```

## 5. Membuat View Login
Membuat View Login Buat direktori baru dengan nama user pada direktori app/views, kemudian buat file baru dengan nama login.php.  
![image](https://github.com/user-attachments/assets/f06c1eae-45c9-4fec-967a-c87b920f6781)
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="icon" href="<?= base_url('/favicon.ico'); ?>">
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        #login-wrapper {
            background: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
            width: 350px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 8px;
            background: #555;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .alert {
            background: #f8d7da;
            padding: 10px;
            color: #721c24;
            border: 1px solid #f5c6cb;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .logout-btn {
            background: #c0392b;
            width: auto;
            padding: 8px 16px;
        }
    </style>
</head>
<body>

    <div id="login-wrapper">
        <h1>Sign In</h1>
        <?php if(session()->getFlashdata('flash_msg')):?>
            <div class="alert"><?= session()->getFlashdata('flash_msg') ?></div>
        <?php endif;?>

        <!-- Form login baru -->
        <form action="" method="post">
            <label>Email address</label>
            <input type="email" name="email" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>

```

## 6. Membuat Database Seeder
Membuat Database Seeder Database seeder digunakan untuk membuat data dummy. Untuk keperluan ujicoba modul login, kita perlu memasukkan data user dan password kedaalam database. Untuk itu buat database seeder untuk tabel user. Buka CLI, kemudian tulis perintah berikut:
Perintah CLI:  
```
php spark make:seeder UserSeeder
```
![image](https://github.com/user-attachments/assets/8f6da287-5624-45f3-974f-7dfe3c3543c4)
Selanjutnya buka kembali CLI dan ketik perintah berikut:  
![seed](https://github.com/user-attachments/assets/ffc11cfb-96dd-4f5a-bb07-23eb4bb94b7d)

## 7. Uji Coba Login
Selanjutnya buka url http://localhost:8080/user/login seperti berikut:  
![Screenshot 2025-07-01 141414](https://github.com/user-attachments/assets/d2272e57-9b2d-4cfa-a63b-e24dd6447409)

## 8. Menambahkan Auth Filters
Menambahkan Auth Filter Selanjutnya membuat filer untuk halaman admin. Buat file baru dengan nama Auth.php pada direktori app/Filters.  
![Screenshot 2025-07-01 141534](https://github.com/user-attachments/assets/c7a6324a-3e24-40b4-9d03-1a72506113ad)

## 9. Buka file app/Config/Filters.php
Lalu tambahkan kode berikut:  
![Screenshot 2025-07-01 141705](https://github.com/user-attachments/assets/e66d9c2a-b9ee-4fe7-9d85-9ecbfa92f559)

## 10.  Buka file app/Config/Routes.php
buka file app/Config/Routes.php dan sesuaikan kodenya.  
![image](https://github.com/user-attachments/assets/6953d410-96fd-47f2-a3b6-499db6a8d818)


## 11. Uji Coba Apk
Percobaan Akses Menu Admin Buka url dengan alamat http://localhost:8080/admin/artikel ketika alamat tersebut diakses maka, akan dimuculkan halaman login.  
![Screenshot 2025-07-01 142304](https://github.com/user-attachments/assets/af2b8c49-efcb-48a6-a9c9-79187d8fb576)

## 12. Menambah Fungsi Logout
Fungsi Logout Tambahkan method logout pada Controller User seperti berikut:
![Screenshot 2025-07-01 143103](https://github.com/user-attachments/assets/a361a3df-5b42-41a4-bc7c-881e7abd25b4)

## 13. Membuat Pagination
Untuk membuat pagination, buka Kembali Controller Artikel, kemudian modifikasi kode pada method admin_index seperti berikut.  
```
public function admin_index()
{
    $title = 'Daftar Artikel';
    $q = $this->request->getVar('q') ?? '';
    $model = new ArtikelModel();
    $data = [
        'title' => $title,
        'q' => $q,
        'artikel' => $model->like('judul', $q)->paginate(10),
        'pager' => $model->pager,
    ];
    return view('artikel/admin_index', $data);
}
```

## 14. Buka file views
Kemudian buka file views/artikel/admin_index.php dan tambahkan kode berikut dibawah deklarasi tabel data.  
```
<?=  $pager->link(); ?>
```
Selanjutnya buka kembali menu daftar artikel, tambahkan data lagi untuk melihat hasilnya.  
![Screenshot 2025-07-01 143816](https://github.com/user-attachments/assets/a2a2e39e-b259-4d66-8dae-f21ae1dd73fe)

## 15. Membuat Pencarian
Membuat Pencarian Pencarian data digunakan untuk memfilter data. Untuk membuat pencarian data, buka kembali Controller Artikel, pada method admin_index ubah kodenya seperti berikut:  
```
public function admin_index()
{
    $title = 'Daftar Artikel';
    $q = $this->request->getVar('q') ?? '';
    $model = new ArtikelModel();

    $data = [
        'title'   => $title,
        'q'       => $q,
        'artikel' => $model->like('judul', $q)->paginate(10), // data dibatasi 10
        'pager'   => $model->pager,
    ];

    return view('artikel/admin_index', $data);
}
```
## 16. Buka file views/artikel/admin_index.php
Kemudian buka kembali file views/artikel/admin_index.php dan tambahkan form pencarian sebelum deklarasi tabel seperti berikut:  
```
<form method="get" class="form-search">
    <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari data">
    <input type="submit" value="Cari" class="btn btn-primary">
</form>
```
Dan pada link pager ubah seperti berikut.  
```
<?= $pager->only(['q'])->links(); ?>
```

## 17. Uji Coba
Selanjutnya ujicoba dengan membuka kembali halaman admin artikel, masukkan kata kunci tertentu pada form pencarian.  
![Screenshot 2025-07-01 144746](https://github.com/user-attachments/assets/7cf3b0cf-793c-4112-87de-021777a29a75)

## 18. Upload Gambar
Upload Gambar pada Artikel Menambahkan fungsi unggah gambar pada tambah artikel. Buka kembali Controller Artikel pada project sebelumnya, sesuaikan kode pada method add seperti berikut:  
```
public function add()
{
    // validasi data.
    $validation = \Config\Services::validation();
    $validation->setRules(['judul' => 'required']);
    $isDataValid = $validation->withRequest($this->request)->run();

    if ($isDataValid)
    {
        $artikel = new ArtikelModel();
        $artikel->insert([
            'judul' => $this->request->getPost('judul'),
            'isi'   => $this->request->getPost('isi'),
            'slug'  => url_title($this->request->getPost('judul')),
        ]);

        return redirect('admin/artikel');
    }

    $title = "Tambah Artikel";
    return view('artikel/form_add', compact('title'));
}
```

## 19. Buka file views/artikel/form_add.php
Kemudian pada file views/artikel/form_add.php tambahkan field input file seperti berikut.  
```
<p>
<input type="file" name="gambar">
</p>
```
## 20. Dan sesuaikan tag form dengan menambahkan ecrypt type seperti berikut.
```
<form action="" method="post" enctype="multipart/form-data">
```
## 21. Uji Coba
Ujicoba file upload dengan mengakses menu tambah artikel.  
![Screenshot 2025-07-01 145319](https://github.com/user-attachments/assets/2c5aace5-e2ec-42b1-a697-e02524538051)
