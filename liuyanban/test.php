<?php
session_start();
// 检查是否存在用户名
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo "欢迎, " . htmlspecialchars($username) . "!";
} else {
    echo "您还未登录，请先登录。";
    // 可选：重定向到登录页面
    // header("Location: login.html");
    // exit();
}
// $servername = "localhost";
// $username = "root";
// $password = "root";
// $database = "lybdb";

// // 创建连接
// $conn = mysqli_connect($servername, $username, $password, $database);

// // 检测连接
// if (!$conn) {
//     die("连接失败: " . mysqli_connect_error());
// } 
// echo "连接成功<br>";

// // 设置字符集
// mysqli_set_charset($conn, "utf8mb4");

// // 修正后的 SQL 语句
// $sql = "SELECT username, password FROM lyb_user WHERE password='123456'";

// $retal = $conn->query($sql);
// if ($retal && $retal->num_rows > 0) {
//     while ($row = $retal->fetch_assoc()) {
//         echo " - Name: " . htmlspecialchars($row["username"]) . " Password: " . htmlspecialchars($row["password"]) . "<br>";
//     echo "数据库查询完成";
// }
// } else {
//     echo "没有找到匹配的记录<br>";
// }


// mysqli_close($conn);
?>
