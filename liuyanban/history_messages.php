<?php
//用于从数据库加载留言并在页面显示。
require('conndb.php');
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
} 
//准备sql语句查询留言
$sql = "SELECT user_username, message, updated_at FROM messages ORDER BY updated_at DESC LIMIT $offset, $limit";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>" . $row['user_username'] . ":</strong> " . $row['message'] . "<br><small>时间: " . $row['updated_at'] . "</small></p>";
    }
} else {
    echo "<p>暂无留言</p>";
}

// 关闭数据库连接
$conn->close();
?>