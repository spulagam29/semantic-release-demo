<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'practicedb';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$result = $conn->query('SELECT id, Name, Type, Origin, Strength, Price, ImageURL, Description FROM teas ORDER BY Name ASC');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Manage Teas — Assessment2</title>
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
            margin-top: 51px;
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

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 8%;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            padding: 10px 2%;
        }

        .product-card {
            background: #fff;
            margin: 10px;
            padding: 20px;
            width: 260px;
            text-align: left;
            border-radius: 10px;
            box-shadow: 0 4px 6px #cefdceff;
        }

        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .actions {
            display: flex;
            gap: 8px;
            margin-top: 10px
        }

        .btn-outline {
            background: transparent;
            color: black;
            border: 1px solid black;
            border-radius: 6px;
            padding: 8px 10px;
            text-decoration: none
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
        <div class="toolbar">
            <h2>Teas</h2>
            <a class="btn" href="teas_insert.php">+ Add New Tea</a>
        </div>

        <div class="product-container">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($row['ImageURL']) ?>" alt="<?= htmlspecialchars($row['Name']) ?>">
                        <h2 style="margin:10px 0 6px 0;"><?= htmlspecialchars($row['Name']) ?></h2>
                        <div>Type: <strong><?= htmlspecialchars($row['Type']) ?></strong></div>
                        <div>Origin: <?= htmlspecialchars($row['Origin']) ?></div>
                        <div>Strength: <?= htmlspecialchars($row['Strength']) ?></div>
                        <div>Price: ₹<?= htmlspecialchars($row['Price']) ?></div>
                        <p style="margin-top:8px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;text-overflow:ellipsis;">
                            <?= htmlspecialchars($row['Description']) ?>
                        </p>
                        <div class="actions">
                            <a class="btn-outline" href="teas_edit.php?id=<?= (int)$row['id'] ?>">Edit</a>
                            <a class="btn-outline" href="teas_delete.php?id=<?= (int)$row['id'] ?>">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="padding:0 8%;">No teas found.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="bottom">
            <p>Let's try now, Sign up to be a Member!!!</p>
            <p class="mail">Join with your Email Address</p>
            <div class="now"><a href="subscribe.php"><button type="button">Subscribe now</button></a></div>
        </div>
    </footer>
</body>

</html>
<?php $conn->close(); ?>