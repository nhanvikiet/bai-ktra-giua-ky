
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hiển thị Thông tin NHANVIEN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .thumbnail {
            width: 50px;
        }

        .add-button {
            margin-bottom: 10px;
        }

        .pagination {
            margin-top: 10px;
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            margin-right: 5px;
            background-color: #f2f2f2;
            color: #333;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .add-button {
        margin-bottom: 10px;
    }
    .edit-button button {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        font-size: 14px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .delete-button button {
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        font-size: 14px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .add-button button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
        .pagination a.active {
            background-color: #007bff;
            color: #fff;
            
        }
    </style>
</head>
<body>
    <?php
    session_start();
    $role = $_SESSION['role'];

    if ($role === 'admin') {
        echo '<div class="container">
                  <a class="add-button" href="add_nhanvien.php"><button>Thêm nhân viên</button></a>';
    }
    ?>

    <h1>Thông Tin NHANVIEN</h1>

    <div class="container">
        <?php
        $connection = mysqli_connect('localhost', 'root', '', 'QL_NhanSu');

        if (!$connection) {
            die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
        }

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 5;
        $start = ($page - 1) * $limit;

        $query = "SELECT Ma_NV, TEN_NV, Phai, Noi_Sinh, Ma_Phong, Luong FROM NHANVIEN LIMIT $start, $limit";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("Lỗi truy vấn: " . mysqli_error($connection));
        }
        ?>

        <table>
            <tr>
                <th>Mã Nhân Viên</th>
                <th>Tên Nhân Viên</th>
                <th>Phái</th>
                <th>Nơi Sinh</th>
                <th>Mã Phòng</th>
                <th>Lương</th>
                <?php if ($role === 'admin') {
                    echo "<th>ACTION</th>";
                } ?>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['Ma_NV'] . "</td>";
                echo "<td>" . $row['TEN_NV'] . "</td>";
                echo "<td><img class='thumbnail' src='http://localhost/KTgiuaKi/images/" . ($row['Phai'] == 'NU' ? 'woman.png' : 'man.png') . "' alt='Hình ảnh'></td>";
                echo "<td>" . $row['Noi_Sinh'] . "</td>";
                echo "<td>" . $row['Ma_Phong'] . "</td>";
                echo "<td>" . $row['Luong'] . "</td>";
                if ($role === 'admin') {
                    echo "<td>
                              <form style='display: inline-block;' class='edit-button' action='edit_nhanvien.php' method='GET'>
                                  <input type='hidden' name='id' value='" . $row['Ma_NV'] . "'>
                                  <button type='submit'>Sửa</button>
                              </form>
                              <form style='display: inline-block;' class='delete-button' action='delete_nhanvien.php' method='GET'>
                                  <input type='hidden' name='id' value='" . $row['Ma_NV'] . "'>
                                  <button type='submit'>Xóa</button>
                              </form>
                          </td>";
                }
                echo "</tr>";
            }
            ?>
        </table>

        <?php
        $totalQuery = "SELECT COUNT(*) AS total FROM NHANVIEN";
        $totalResult = mysqli_query($connection, $totalQuery);
        $totalRow = mysqli_fetch_assoc($totalResult);
        $totalEmployees = $totalRow['total'];

        $totalPages = ceil($totalEmployees / $limit);

        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='?page=$i' " . ($i == $page ? "class='active'" : "") . ">$i</a>";
        }
        echo "</div>";
        ?>
    </div>
</body>
</html>

<?php

mysqli_close($connection);
?>