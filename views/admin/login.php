<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | <?= APP_NAME ?></title>
    <!-- Use the existing admin styling foundation if possible, or define secure self-contained styles -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Using Lucide icons like the rest of the site -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --primary: #bd0028; /* The red from the vapestore */
            --bg-dark: #0a0a0a;
            --surface: #1a1a1a;
            --text-light: #ffffff;
            --text-muted: #94a3b8;
            --error: #e16449;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: var(--surface);
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 1px solid #333;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .login-header p {
            color: var(--text-muted);
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: var(--text-muted);
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            background: #2a2a2a;
            border: 1px solid #444;
            border-radius: 6px;
            color: white;
            font-size: 14px;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-login:hover {
            background: #a00022;
        }
        .flash-message {
            background: rgba(225, 100, 73, 0.1);
            color: var(--error);
            padding: 10px;
            border-radius: 6px;
            border: 1px solid var(--error);
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <!-- Replace with actual logo if needed -->
            <h1>Admin Portal</h1>
            <p>Secure backend access</p>
        </div>

        <?php if(isset($flash) && $flash): ?>
            <div class="flash-message">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/admin/login" method="POST">
            <div class="form-group">
                <label for="email">Admin Email</label>
                <input type="email" id="email" name="email" required autocomplete="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-login">Login Securely</button>
        </form>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
