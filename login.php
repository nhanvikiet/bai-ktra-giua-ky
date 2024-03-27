<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Đăng nhập</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Kết nối đến cơ sở dữ liệu
            $connection = mysqli_connect('localhost', 'root', '', 'QL_NhanSu');

            // Kiểm tra kết nối
            if (!$connection) {
                die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
            }

            // Xây dựng truy vấn SQL để kiểm tra thông tin đăng nhập
            $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
            $result = mysqli_query($connection, $query);

            if (!$result) {
                die("Lỗi truy vấn: " . mysqli_error($connection));
            }

            // Kiểm tra số lượng bản ghi trả về từ truy vấn
            if (mysqli_num_rows($result) == 1) {
                // Đăng nhập thành công, lấy thông tin người dùng
                $user = mysqli_fetch_assoc($result);

                // Lưu thông tin người dùng vào session hoặc cookie
                // Ví dụ:
                session_start();
                $_SESSION['user_id'] = $user['Id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // Đóng kết nối cơ sở dữ liệu
                mysqli_close($connection);

                // Chuyển hướng đến trang employee_list.php
                header('Location: nhanvien_list.php');
                exit();
            } else {
                // Đăng nhập không thành công, hiển thị thông báo lỗi
                echo "<p class='error-message'>Sai tên đăng nhập hoặc mật khẩu. Vui lòng thử lại.</p>";
            }

            // Đóng kết nối cơ sở dữ liệu
            mysqli_close($connection);
        }
        ?>
        <form method="POST" action="login.php">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Đăng nhập">
        </form>
    </div>
