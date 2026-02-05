<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'practicedb';
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die('Invalid id');
}

// fetch for display
$stmt = $conn->prepare('SELECT Name FROM teas WHERE id=?');
$stmt->bind_param('i', $id);
$stmt->execute();
$tea = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$tea) {
    die('Tea not found');
}

$deleted = FALSE;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    $del = $conn->prepare('DELETE FROM teas WHERE id=?');
    $del->bind_param('i', $id);

    if ($del->execute()) {
        $deleted = TRUE;
    }
    $del->close();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Delete Tea — Assessment2</title>
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
            padding: 24px 8%;
            max-width: 700px;
            margin: auto;
        }

        .card {
            background: #fff;
            padding: 18px;
            border-radius: 10px;
            box-shadow: 0 4px 6px #cefdceff;
        }

        .btn {
            background: black;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 14px;
            cursor: pointer
        }

        .btn-outline {
            background: transparent;
            border: 1px solid black;
            color: black;
            border-radius: 6px;
            padding: 10px 14px;
            cursor: pointer;
            text-decoration: none
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

        .warn {
            background: #fff6e6;
            border: 1px solid #ffd59a
        }

        footer .bottom {
            background: #cdffcd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 8%;
        }

        form {
            display: flex;
            gap: 10px
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
                <a href="teas_admin.php" class="btn">Manage Teas</a>
            </div>
        </nav>
    </header>

    <main class="page-wrap">
        <div class="wrap">
            <?php if ($deleted): ?>
                <div class="alert success">Tea deleted. <a href="teas_admin.php">Back to list</a></div>
            <?php else: ?>
                <div class="card warn">
                    <h3 style="margin-top:0;">Delete “<?= htmlspecialchars($tea['Name']) ?>”?</h3>
                    <p>This action cannot be undone.</p>
                    <form method="POST" action="">
                        <input type="hidden" name="confirm" value="yes">
                        <button type="submit" class="btn">Yes, delete</button>
                        <a class="btn-outline" href="teas_admin.php">Cancel</a>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="bottom">
            <p>Let's try now, Sign up to be a Member!!!</p>
            <p class="mail">Join with your Email Address</p>
            <div class="now"><a href="subscribe.php"><button type="button">Subscribe now!!!!!!</button></a></div>
        </div>
    </footer>
</body>

</html>
<?php $conn->close(); ?>