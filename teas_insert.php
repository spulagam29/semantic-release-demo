<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'practicedb';
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$types = ['Green', 'Black', 'Herbal', 'Oolong', 'Spiced', 'White'];
$strengths = ['Light', 'Medium', 'Strong'];

$errors = [];
$done = FALSE;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Name = trim($_POST['Name'] ?? '');
    $Type = trim($_POST['Type'] ?? '');
    $Origin = trim($_POST['Origin'] ?? '');
    $Strength = trim($_POST['Strength'] ?? '');
    $Price = trim($_POST['Price'] ?? '');
    $ImageURL = trim($_POST['ImageURL'] ?? '');
    $Description = trim($_POST['Description'] ?? '');

    if ($Name === '') {
        $errors[] = 'Name is required.';
    }

    if (!in_array($Type, $types, TRUE)) {
        $errors[] = 'Invalid Type.';
    }

    if ($Strength !== '' && !in_array($Strength, $strengths, TRUE)) {
        $errors[] = 'Invalid Strength.';
    }

    if ($Price === '' || !is_numeric($Price) || (float)$Price < 0) {
        $errors[] = 'Price must be a non-negative number.';
    }

    if (!$errors) {
        $stmt = $conn->prepare('INSERT INTO teas (Name, Type, Origin, Strength, Price, ImageURL, Description) VALUES (?, ?, ?, ?, ?, ?, ?)');

        if (!$stmt) {
            $errors[] = 'Prepare failed.';
        } else {
            $priceFloat = (float)$Price;
            $stmt->bind_param('ssssdds', $Name, $Type, $Origin, $Strength, $priceFloat, $ImageURL, $Description);

            if ($stmt->execute()) {
                $done = TRUE;
            } else {
                $errors[] = 'Insert failed: ' . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Add Tea — Assessment2</title>
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
            max-width: 900px;
            margin: auto;
        }

        .card {
            background: #fff;
            padding: 18px;
            border-radius: 10px;
            box-shadow: 0 4px 6px #cefdceff;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px
        }

        input,
        select,
        textarea {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 100%
        }

        textarea {
            grid-column: 1 / -1
        }

        .row {
            grid-column: 1 / -1;
            display: flex;
            gap: 10px
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
                <a href="teas_admin.php" class="btn">Manage Teas</a>
            </div>
        </nav>
    </header>

    <main class="page-wrap">
        <div class="wrap">
            <?php if ($done): ?>
                <div class="alert success">Tea added successfully. <a href="teas_admin.php">Back to list</a></div>
            <?php elseif ($errors): ?>
                <div class="alert error"><?php foreach ($errors as $e) {
                    echo '<div>' . htmlspecialchars($e) . '</div>';
                } ?></div>
            <?php endif; ?>

            <div class="card">
                <h2 style="margin-top:0">Add New Tea</h2>
                <form method="POST" action="">
                    <input type="text" name="Name" placeholder="Name *" value="<?= htmlspecialchars($_POST['Name'] ?? '') ?>" required>
                    <select name="Type" required>
                        <option value="">Type *</option>
                        <?php foreach ($types as $t): ?>
                            <option value="<?= $t ?>" <?= (($_POST['Type'] ?? '') === $t) ? 'selected' : '' ?>><?= $t ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="Origin" placeholder="Origin" value="<?= htmlspecialchars($_POST['Origin'] ?? '') ?>">
                    <select name="Strength">
                        <option value="">Strength</option>
                        <?php foreach ($strengths as $s): ?>
                            <option value="<?= $s ?>" <?= (($_POST['Strength'] ?? '') === $s) ? 'selected' : '' ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" step="0.01" min="0" name="Price" placeholder="Price (₹) *" value="<?= htmlspecialchars($_POST['Price'] ?? '') ?>" required>
                    <input type="url" name="ImageURL" placeholder="Image URL" value="<?= htmlspecialchars($_POST['ImageURL'] ?? '') ?>">
                    <textarea name="Description" rows="5" placeholder="Description"><?= htmlspecialchars($_POST['Description'] ?? '') ?></textarea>
                    <div class="row">
                        <button class="btn" type="submit">Save</button>
                        <a class="btn-outline" href="teas_admin.php">Cancel</a>
                    </div>
                </form>
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
<?php $conn->close(); ?>