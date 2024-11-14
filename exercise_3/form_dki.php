<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Đăng ký người dùng</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
        }

        .dangki {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);

        }

        .dangki h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .dangki input[type="text"],
        .dangki input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .dangki input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dangki input[type="submit"]:hover {
            background-color: #45a049;
        }

        .dangki p {
            font-size: 14px;
            margin: 5px 0;
        }

        .dangki p.error {
            color: #e74c3c;
        }

        .dangki p.success {
            color: #2ecc71;
        }
    </style>
</head>

<body>
    <div class="dangki">
        <h2>Đăng ký người dùng</h2>
        <form method="POST" action="">
            Tên người dùng: <input type="text" name="username"><br><br>
            Email: <input type="text" name="email"><br><br>
            Mật khẩu: <input type="password" name="password"><br><br>
            <input type="submit" value="Đăng ký">
        </form>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $errors = [];

            if (empty($username)) {
                $errors[] = "Tên người dùng không được để trống.";
            }
            if (empty($email)) {
                $errors[] = "Email không được để trống.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ.";
            }
            if (empty($password)) {
                $errors[] = "Mật khẩu không được để trống.";
            } elseif (strlen($password) < 8) {
                $errors[] = "Mật khẩu phải có ít nhất 8 ký tự.";
            }

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>";
                }
            } else {
                if (saveDataJSON('users.json', $username, $email, $password)) {
                    echo "<p class='success'>Đăng ký thành công!</p>";
                } else {
                    echo "<p class='error'>Lỗi khi lưu dữ liệu!</p>";
                }
            }
        }

        function saveDataJSON($filename, $username, $email, $password)
        {
            $user = [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];

            if (file_exists($filename)) {
                $data = json_decode(file_get_contents($filename), true);
            } else {
                $data = [];
            }

            $data[] = $user;

            return file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
        }
        ?>

    </div>
</body>

</html>