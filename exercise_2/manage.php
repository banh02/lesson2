<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Sản phẩm</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            display: flex;
            flex-direction: column;
            max-width: 400px;
            gap: 15px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Quản lý Sản phẩm</h1>

        <form method="post">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" required>

            <label for="price">Giá:</label>
            <input type="number" id="price" name="price" required>

            <label for="quantity">Số lượng:</label>
            <input type="number" id="quantity" name="quantity" required>

            <button type="submit" name="action" value="add">Thêm sản phẩm</button>
        </form>

        <div class="actions">
            <form method="post">
                <button type="submit" name="action" value="display">Hiển thị danh sách</button>
            </form>

            <form method="post">
                <button type="submit" name="action" value="sort">Sắp xếp theo tên</button>
            </form>

            <form method="post">
                <label for="search">Tìm kiếm:</label>
                <input type="text" id="search" name="keyword">
                <button type="submit" name="action" value="search">Tìm kiếm</button>
            </form>
        </div>
    </div>

    <?php
    session_start();

    if (!isset($_SESSION['products'])) {
        $_SESSION['products'] = [];
    }

    $products = &$_SESSION['products'];

    function addProduct(&$products, $name, $price, $quantity)
    {
        $products[] = ['name' => $name, 'price' => $price, 'quantity' => $quantity];
    }

    function displayProducts($products)
    {
        if (empty($products)) {
            echo "<p>Danh sách sản phẩm trống.</p>";
            return;
        }
        echo "<table><tr><th>Tên sản phẩm</th><th>Giá</th><th>Số lượng</th></tr>";
        foreach ($products as $product) {
            echo "<tr><td>" . htmlspecialchars($product['name']) . "</td>";
            echo "<td>" . htmlspecialchars(number_format($product['price'], 0, ',', '.')) . "</td>";
            echo "<td>" . htmlspecialchars($product['quantity']) . "</td></tr>";
        }
        echo "</table>";
    }

    function searchProduct($products, $keyword)
    {
        return array_filter($products, function ($product) use ($keyword) {
            return stripos($product['name'], $keyword) !== false;
        });
    }

    function sortProductsByName(&$products)
    {
        usort($products, fn($a, $b) => strcasecmp($a['name'], $b['name']));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];
        if ($action === 'add') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];

            if (!empty($name) && is_numeric($price) && is_numeric($quantity)) {
                addProduct($products, $name, $price, $quantity);
                echo "<p>Đã thêm sản phẩm: $name</p>";
            } else {
                echo "<p>Vui lòng nhập dữ liệu hợp lệ!</p>";
            }
        }

        if ($action === 'display') {
            displayProducts($products);
        }

        if ($action === 'sort') {
            sortProductsByName($products);
            echo "<p>Danh sách sản phẩm sau khi sắp xếp:</p>";
            displayProducts($products);
        }

        if ($action === 'search') {
            $keyword = $_POST['keyword'];
            $results = searchProduct($products, $keyword);
            if ($results) {
                echo "<p>Kết quả tìm kiếm:</p>";
                displayProducts($results);
            } else {
                echo "<p>Không tìm thấy sản phẩm nào.</p>";
            }
        }
    }
    ?>
</body>

</html>