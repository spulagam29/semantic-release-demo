<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'practicedb';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$done = FALSE;
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err = 'Please enter a valid email.';
    } else {
        $conn->query('CREATE TABLE IF NOT EXISTS subscribers (
      id INT UNSIGNED NOT NULL AUTO_INCREMENT,
      email VARCHAR(255) NOT NULL UNIQUE,
      name  VARCHAR(120) NULL,
      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $stmt = $conn->prepare('INSERT INTO subscribers (email, name) VALUES (?, ?)');

        if ($stmt) {
            $stmt->bind_param('ss', $email, $name);

            try {
                $stmt->execute();
                $done = TRUE;
            } catch (Throwable $t) {
                $err = 'Looks like this email is already subscribed.';
            }
            $stmt->close();
        } else {
            $err = 'Unable to prepare subscription. Try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Subscribe — Assessment2</title>
    <style>
        body {
            padding: 0;
            margin: 0;
        }

        .startLine {
            background: black;
            color: white;
            font-size: 20px;
            position: fixed;
            width: 100%;
            text-align: center;
        }

        nav {
            margin-top: 50px;
            background: #cdffcd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            position: fixed;
        }

        .logo {
            padding: 15px;
            width: 60px;
            height: 60px;
        }

        .navnames {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .navnames a {
            text-decoration: none;
            color: black;
            font-size: 20px;
            padding: 15px;
        }

        .page-wrap {
            padding-top: 140px;
        }

        .wrap {
            display: flex;
            gap: 24px;
            padding: 24px 8%;
        }

        .card {
            background: #fff;
            padding: 18px;
            border-radius: 10px;
            box-shadow: 0 4px 6px #cefdceff;
        }

        .left {
            flex: 1
        }

        .right {
            flex: 1
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 12px
        }

        input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px
        }

        button {
            background: black;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 14px;
            cursor: pointer
        }

        .alert {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 10px
        }

        .success {
            background: #e6ffe6;
            border: 1px solid #9ae19a
        }

        .error {
            background: #ffe6e6;
            border: 1px solid #ff9a9a
        }

        ul {
            margin: 8px 0 0 16px
        }

        footer .bottom {
            background: #cdffcd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 8%;
        }
    </style>
</head>

<body>
    <div class="startLine">
        <p>For Free Shipping on Orders above $100 and more use coupon FREESHIP</p>
    </div>
    <header>
        <nav>
            <div class="navnames">
                <img class="logo" src="https://img.freepik.com/premium-vector/green-tea-cup-with-leaves-logo-organic-products-wellness-ecofriendly-branding_1299084-12018.jpg?semt=ais_hybrid&w=740" alt="logo">
                <a href="assessment2.php">Shop!</a>
                <a href="subscribe.php">Subscribe!</a>
                <a href="about.php">About!</a>
                <a href="contact.php" target="_blank">Contact!</a>
                <a href="teas_admin.php">Manage Teas!</a>
            </div>
        </nav>
    </header>

    <main class="page-wrap">
        <div class="wrap">
            <div class="left card">
                <h2>Subscribe to updates</h2>
                <?php if ($done): ?>
                    <div class="alert success">Thanks for subscribing! We’ll keep your inbox tea-friendly.</div>
                <?php elseif ($err): ?>
                    <div class="alert error"><?= htmlspecialchars($err) ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <input type="text" name="name" placeholder="Your name (optional)" value="<?= htmlspecialchars($name ?? '') ?>">
                    <input type="email" name="email" placeholder="Your email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
            <div class="right card">
                <h3>Why Subscribe?</h3>
                <ul>
                    <li>Early access to fresh harvests</li>
                    <li>Member-only promos</li>
                    <li>Brewing tips & guides</li>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <div class="bottom">
            <p>Let's try now, Sign up to be a Member</p>
            <p class="mail">Join with your Email Address</p>
            <div class="now"><a href="subscribe.php"><button type="button">Subscribe now</button></a></div>
        </div>
    </footer>
</body>

</html>