<?php
require 'config.php';
require 'helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pwd = $_POST['password'];
    $stmt = $mysqli->prepare("SELECT id, name, email, password, is_admin FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $u = $stmt->get_result()->fetch_assoc();
    
    if ($u && password_verify($pwd, $u['password'])) {
        $_SESSION['user'] = ['id' => $u['id'], 'name' => $u['name'], 'email' => $u['email'], 'is_admin' => $u['is_admin']];
        header('Location: index.php');
        exit;
    } else {
        $error = "Login gagal: cek email / password";
    }
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login | OVER Luxury Member</title>
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

        /* Login Box Styling */
        .login-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .login-box {
            background-color: var(--dark-gray);
            border: 1px solid #333;
            padding: 40px;
            width: 100%;
            max-width: 450px;
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

        /* Buttons */
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

        .btn-link-gold:hover {
            color: #fff;
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

    <div class="login-wrapper">
        <div class="login-box shadow-lg">
            <div class="text-center mb-4">
                <h2 class="fw-bold">Welcome <span style="color: var(--gold);">Back</span></h2>
                <p class="text-secondary small">Masuk untuk melanjutkan pengalaman belanja mewah Anda.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-luxury text-center mb-4"><?= e($error) ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-4">
                    <label>Email Address</label>
                    <input name="email" type="email" class="form-control" placeholder="nama@email.com" required>
                </div>
                <div class="mb-4">
                    <label>Password</label>
                    <input name="password" type="password" class="form-control" placeholder="••••••••" required>
                </div>
                
                <button class="btn btn-gold mb-3">Sign In</button>
                
                <div class="text-center">
                    <span class="text-secondary small">Belum punya akun?</span>
                    <a href="register.php" class="btn-link-gold fw-bold ms-1">Register Now!</a>
                </div>
            </form>
        </div>
    </div>

    <footer class="text-center py-4 border-top border-dark opacity-50">
        <small class="text-secondary">© <?= date('Y') ?> OVER STORE. Excellence in Hygiene.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>