<?php

if (isset($_GET['id'])) {
    
    $id = $_GET['id'];

    
    $connection = mysqli_connect('localhost', 'root', '', 'QL_NhanSu');

    
    if (!$connection) {
        die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $query = "DELETE FROM NHANVIEN WHERE Ma_NV = ?";
        $statement = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($statement, 's', $id);
        $result = mysqli_stmt_execute($statement);

        if ($result) {
            
            header("Location: nhanvien_list.php");
            exit();
        } else {
            echo "Lỗi xóa nhân viên: " . mysqli_error($connection);
        }
    }

    
    $query = "SELECT * FROM NHANVIEN WHERE Ma_NV = ?";
    $statement = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($statement, 's', $id);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

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
            <title>Xóa nhân viên</title>
        </head>
        <body>
            <h1>Xóa nhân viên</h1>
            <p>Bạn có chắc chắn muốn xóa nhân viên "<?php echo $row['Ten_NV']; ?>"?</p>
            <form method="POST" action="">
                <input type="submit" value="Xóa">
            </form>
        </body>
        </html>
        <?php
    } else {
        
        header("Location: nhanvien_list.php");
        exit();
    }

    
    mysqli_close($connection);
} else {
    echo "Không tìm thấy thông tin nhân viên!";
}
?>