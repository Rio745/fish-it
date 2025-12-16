<?php
require 'config.php';
require 'helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pwd = $_POST['password'];

    // Menghitung hash password untuk keamanan
    $hash = password_hash($pwd, PASSWORD_DEFAULT);
    
    $stmt = $mysqli->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $name, $email, $hash);
    
    if ($stmt->execute()) {
        // Otomatis set session jika pendaftaran berhasil
        $_SESSION['user'] = ['id' => $stmt->insert_id, 'name' => $name, 'email' => $email, 'is_admin' => 0];
        header('Location: index.php');
        exit;
    } else {
        $error = "Pendaftaran gagal: Email mungkin sudah terdaftar.";
    }
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Join OVER | Luxury Member Registration</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4AF37;
            --black: #000000;
            --dark-gray: #1a1a1a;
        }

        body {
            background-color: var(--black);
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h2, label, .navbar-brand {
            font-family: 'Playfair Display', serif;
        }

        .navbar {
            background-color: var(--black) !important;
            border-bottom: 1px solid var(--gold);
        }

        .register-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .register-box {
            background-color: var(--dark-gray);
            border: 1px solid #333;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }

        .form-control {
            background-color: #000;
            border: 1px solid #444;
            color: #fff;
            border-radius: 0;
            padding: 12px;
        }

        .form-control:focus {
            background-color: #000;
            border-color: var(--gold);
            color: #fff;
            box-shadow: none;
        }

        label {
            color: var(--gold);
            margin-bottom: 8px;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .btn-gold {
            background-color: var(--gold);
            color: var(--black);
            font-weight: 600;
            border-radius: 0;
            padding: 12px;
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-gold:hover {
            background-color: #fff;
            color: #000;
        }

        .btn-link-gold {
            color: var(--gold);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .alert-luxury {
            background-color: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            border-radius: 0;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand mx-auto" href="index.php">
                <img src="assets/images/brand.png" alt="OVER" style="height: 50px;">
            </a>
        </div>
    </nav>

    <div class="register-wrapper">
        <div class="register-box shadow-lg">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Create <span style="color: var(--gold);">Account</span></h2>
                <p class="text-secondary small">Bergabunglah untuk akses ke koleksi eksklusif.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-luxury text-center mb-4"><?= e($error) ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label>Full Name</label>
                    <input name="name" type="text" class="form-control" placeholder="Nama Lengkap Anda" required>
                </div>
                <div class="mb-3">
                    <label>Email Address</label>
                    <input name="email" type="email" class="form-control" placeholder="nama@email.com" required>
                </div>
                <div class="mb-4">
                    <label>Password</label>
                    <input name="password" type="password" class="form-control" placeholder="Min. 8 Karakter" required>
                </div>
                
                <button class="btn btn-gold mb-3">Register Now</button>
                
                <div class="text-center">
                    <span class="text-secondary small">Sudah memiliki akun?</span>
                    <a href="login.php" class="btn-link-gold fw-bold ms-1">Sig IN</a>
                </div>
            </form>
        </div>
    </div>

    <footer class="text-center py-4 border-top border-dark opacity-50">
        <small class="text-secondary">© <?= date('Y') ?> OVER STORE. Crafted for Comfort.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>