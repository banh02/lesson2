<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập Ma Trận và Tìm Phần Tử Lớn Nhất</title>
</head>

<body>
    <h2>Nhập ma trận số thực</h2>

    <form method="post" action="">
        <label>Số hàng:</label>
        <input type="number" name="rows" min="1" required><br><br>

        <label>Số cột:</label>
        <input type="number" name="columns" min="1" required><br><br>

        <button type="submit" name="submit_size">Xác nhận kích thước</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_size'])) {
        $rows = (int) $_POST['rows'];
        $columns = (int) $_POST['columns'];

        if ($rows > 0 && $columns > 0) {
            echo "<h3>Nhập các phần tử của ma trận $rows x $columns:</h3>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='rows' value='$rows'>";
            echo "<input type='hidden' name='columns' value='$columns'>";

            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $columns; $j++) {
                    echo "Phần tử [$i][$j]: <input type='number' step='any' name='element_{$i}_{$j}' required> ";
                }
                echo "<br>";
            }

            echo "<button type='submit' name='submit_matrix'>Tìm phần tử lớn nhất</button>";
            echo "</form>";
        } else {
            echo "<p style='color:red;'>Số hàng và số cột phải lớn hơn 0.</p>";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_matrix'])) {
        $rows = (int) $_POST['rows'];
        $columns = (int) $_POST['columns'];

        $matrix = [];
        $maxValue = null;
        $maxPosition = [0, 0];

        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $columns; $j++) {
                $value = (float) $_POST["element_{$i}_{$j}"];
                $matrix[$i][$j] = $value;

                if ($maxValue === null || $value > $maxValue) {
                    $maxValue = $value;
                    $maxPosition = [$i + 1, $j + 1];
                }
            }
        }

        echo "<h3>Ma trận đã nhập:</h3><table border='1'>";
        foreach ($matrix as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>$cell</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        echo "<h3>Kết quả:</h3>";
        echo "Phần tử lớn nhất là <strong>$maxValue</strong> tại tọa độ (" . $maxPosition[0] . ", " . $maxPosition[1] . ")";
    }
    ?>
</body>

</html>