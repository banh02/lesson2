<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        color: #fff;
        font-size: 28px;
    }

    .search {
        width: 500px;
        padding: 50px;
        background: blueviolet;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    input {
        padding: 10px;
    }

    input[type="submit"] {
        border-radius: 60px;
        color: #333;
    }

    input[type="text"] {
        color: #333;
    }
</style>

<body>
    <div class="search">
        <h2>Tìm giá trị nhỏ nhất</h2>
        <form method="post">
            <label for="array">Nhập mảng các số nguyên (các số phải phân tách bằng dấu phẩy):</label><br>
            <input type="text" name="array" id="array" required><br><br>
            <input type="submit" value="Tìm giá trị nhỏ nhất">
        </form>
        <?php
        function findMinIndex($arr)
        {
            if (count($arr) == 0) {
                return -1;
            }

            $minIndex = 0;
            $minValue = $arr[0];

            for ($i = 1; $i < count($arr); $i++) {
                if ($arr[$i] < $minValue) {
                    $minValue = $arr[$i];
                    $minIndex = $i;
                }
            }
            return $minIndex;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $inputArray = trim($_POST['array']);
            if (empty($inputArray)) {
                echo "<p>Vui lòng nhập mảng các số nguyên.</p>";
            } else {
                $array = array_map('intval', explode(',', $inputArray));

                foreach ($array as $value) {
                    if (!is_numeric($value)) {
                        echo "<p>Vui lòng chỉ nhập các số nguyên, phân tách bằng dấu phẩy.</p>";
                        exit;
                    }
                }

                $minIndex = findMinIndex($array);
                if ($minIndex != -1) {
                    echo "<p>Vị trí của phần tử nhỏ nhất là: " . ($minIndex + 1) . "</p>";
                    echo "<p>Giá trị của phần tử nhỏ nhất là: " . $array[$minIndex] . "</p>";
                } else {
                    echo "<p>Mảng trống.</p>";
                }
            }
        }
        ?>
    </div>
</body>

</html>