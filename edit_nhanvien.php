<?php

if (isset($_GET['id'])) {
    
    $id = $_GET['id'];

    
    $connection = mysqli_connect('localhost', 'root', '', 'QL_NhanSu');

    
    if (!$connection) {
        die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $tenNV = $_POST['tenNV'];
        $phai = $_POST['phai'];
        $noiSinh = $_POST['noiSinh'];
        $maPhong = $_POST['maPhong'];
        $luong = $_POST['luong'];

        
        $query = "UPDATE NHANVIEN SET TEN_NV = '$tenNV', Phai = '$phai', Noi_Sinh = '$noiSinh', Ma_Phong = '$maPhong', Luong = '$luong' WHERE Ma_NV = '$id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo "Cập nhật thông tin nhân viên thành công!";
        } else {
            echo "Lỗi cập nhật thông tin nhân viên: " . mysqli_error($connection);
        }
    }

    
    $query = "SELECT * FROM NHANVIEN WHERE Ma_NV = '$id'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($connection));
    }

    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        ?>
        <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sửa thông tin nhân viên</title>
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

        input[type="text"] {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Sửa thông tin nhân viên</h1>
        <form method="POST" action="">
            <label for="tenNV">Tên nhân viên:</label>
            <input type="text" id="tenNV" name="tenNV" value="<?php echo $row['Ten_NV']; ?>"><br>

            <label for="phai">Phái:</label>
            <input type="text" id="phai" name="phai" value="<?php echo $row['Phai']; ?>"><br>

            <label for="noiSinh">Nơi sinh:</label>
            <input type="text" id="noiSinh" name="noiSinh" value="<?php echo $row['Noi_Sinh']; ?>"><br>

            <label for="maPhong">Mã phòng:</label>
            <input type="text" id="maPhong" name="maPhong" value="<?php echo $row['Ma_Phong']; ?>"><br>

            <label for="luong">Lương:</label>
            <input type="text" id="luong" name="luong" value="<?php echo $row['Luong']; ?>"><br>

            <input type="submit" value="Lưu">
        </form>
    </div>
</body>
</html>
        <?php
    } else {
        echo "Không tìm thấy nhân viên!";
    }

   
    mysqli_close($connection);
} else {
    echo "Không tìm thấy thông tin nhân viên!";
}
?>