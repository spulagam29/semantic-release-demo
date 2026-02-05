<?php
$sent = FALSE;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') {
        $errors[] = 'Name is required!.';
    }

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required!.';
    }

    if ($message === '') {
        $errors[] = 'Message cannot be empty.';
    }

    if (!$errors) {
        // You can integrate mail() or store to DB here.
        // mail($to, "New contact from $name", $message, "From: $email");
        $sent = TRUE;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Contact — Assessment2</title>
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

        input,
        textarea {
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
            border-radius: 6px
        }

        .success {
            background: #e6ffe6;
            border: 1px solid #9ae19a
        }

        .error {
            background: #ffe6e6;
            border: 1px solid #ff9a9a
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
                <a href="assessment2.php">Shop</a>
                <a href="subscribe.php">Subscribe</a>
                <a href="about.php">About</a>
                <a href="contact.php" target="_blank">Contact</a>
                <a href="teas_admin.php">Manage Teas</a>
            </div>
        </nav>
    </header>

    <main class="page-wrap">
        <div class="wrap">
            <div class="left card">
                <h2>Get in touch</h2>
                <?php if ($sent): ?>
                    <div class="alert success">Thanks, <?= htmlspecialchars($name ?? '') ?> — we’ve received your message!</div>
                <?php elseif ($errors): ?>
                    <div class="alert error">
                        <?php foreach ($errors as $e) {
                            echo '<div>' . htmlspecialchars($e) . '</div>';
                        } ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <input type="text" name="name" placeholder="Your name" value="<?= htmlspecialchars($name ?? '') ?>" required>
                    <input type="email" name="email" placeholder="Your email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                    <textarea name="message" rows="6" placeholder="Your message..." required><?= htmlspecialchars($message ?? '') ?></textarea>
                    <button type="submit">Send message</button>
                </form>
            </div>
            <div class="right card">
                <h3>Store Info</h3>
                <p><strong>Email:</strong> support@teastore.example</p>
                <p><strong>Phone:</strong> +91 98765 43210</p>
                <p><strong>Hours:</strong> Mon–Sat, 9:00–18:00 IST</p>
                <h3>Address</h3>
                <p>Tea Store HQ, Hill View Road,<br />Darjeeling, West Bengal, India</p>
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