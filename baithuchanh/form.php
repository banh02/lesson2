<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Danh sách khách hàng</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .message {
            text-align: center;
            color: red;
        }

        .profile img {
            width: 50px;
            height: 50px;
        }

        img {
            object-fit: cover;
        }
    </style>
</head>

<body>

    <?php
    $customer_list = array(
        "0" => array("name" => "Mai Văn Hoàn", "day_of_birth" => "1983/08/20", "address" => "Hà Nội", "image" => "../image/istockphoto-2148287052-612x612 (1).jpg"),
        "1" => array("name" => "Nguyễn Văn Nam", "day_of_birth" => "1983/08/21", "address" => "Bắc Giang", "image" => "../image/istockphoto-2148287052-612x612 (1).jpg"),
        "2" => array("name" => "Nguyễn Thái Hòa", "day_of_birth" => "1983/08/22", "address" => "Nam Định", "image" => "../image/istockphoto-2148287052-612x612 (1).jpg"),
        "3" => array("name" => "Trần Đăng Khoa", "day_of_birth" => "1983/08/17", "address" => "Hà Tây", "image" => "../image/istockphoto-2148287052-612x612 (1).jpg"),
        "4" => array("name" => "Nguyễn Đình Thi", "day_of_birth" => "1983/08/19", "address" => "Hà Nội", "image" => "../image/istockphoto-2148287052-612x612 (1).jpg")
    );

    function searchByDate($customers, $from_date, $to_date)
    {
        if (empty($from_date) && empty($to_date)) {
            return $customers;
        }
        $filtered_customers = [];
        foreach ($customers as $customer) {
            if (!empty($from_date) && (strtotime($customer['day_of_birth']) < strtotime($from_date))) {
                continue;
            }
            if (!empty($to_date) && (strtotime($customer['day_of_birth']) > strtotime($to_date))) {
                continue;
            }
            $filtered_customers[] = $customer;
        }
        return $filtered_customers;
    }

    $from_date = NULL;
    $to_date = NULL;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $from_date = $_POST["from"];
        $to_date = $_POST["to"];
    }

    $filtered_customers = searchByDate($customer_list, $from_date, $to_date);
    ?>

    <form method="post">
        Từ: <input id="from" type="text" name="from" placeholder="yyyy/mm/dd" />
        Đến: <input id="to" type="text" name="to" placeholder="yyyy/mm/dd" />
        <input type="submit" id="submit" value="Lọc" />
    </form>

    <table>
        <caption>
            <h2>Danh sách khách hàng</h2>
        </caption>
        <tr>
            <th>STT</th>
            <th>Tên</th>
            <th>Ngày sinh</th>
            <th>Địa chỉ</th>
            <th>Ảnh</th>
        </tr>
        <?php if (count($filtered_customers) === 0): ?>
            <tr>
                <td colspan="5" class="message">Không tìm thấy khách hàng nào</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($filtered_customers as $index => $customer): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($customer['name']); ?></td>
                <td><?php echo htmlspecialchars($customer['day_of_birth']); ?></td>
                <td><?php echo htmlspecialchars($customer['address']); ?></td>
                <td>
                    <div class="profile">
                        <img src="<?php echo htmlspecialchars($customer['image']); ?>" alt="Profile Image" />
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>