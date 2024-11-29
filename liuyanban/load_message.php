<?php
// 用于从数据库加载留言并在页面显示

// 引入数据库连接文件 conndb.php，确保能够连接到数据库
require('conndb.php');

// 启动会话，允许使用 $_SESSION 超全局数组存储和访问会话变量
session_start();

// 检查会话中是否存在用户名
if (isset($_SESSION['username'])) {
    // 如果存在，将用户名存储到变量 $username 中
    $username = $_SESSION['username'];
}

// 准备 SQL 查询语句，用于从 messages 表中查询当前用户的留言，按更新时间倒序排列
$sql = "SELECT user_username, message, updated_at FROM messages WHERE user_username='$username' ORDER BY updated_at DESC";

// 执行 SQL 查询，获取查询结果
$result = $conn->query($sql);

// 检查查询结果是否有行数大于 0（即是否有留言记录）
if ($result->num_rows > 0) {
    // 使用 while 循环遍历结果集中的每一行数据
    while ($row = $result->fetch_assoc()) {
        // 输出留言的 HTML 格式，包括用户名、留言内容和时间
        echo "<p><strong>" . $row['user_username'] . ":</strong> " . $row['message'] . "<br><small>时间: " . $row['updated_at'] . "</small></p>";

        // 输出删除按钮，其中调用 JavaScript 的 deleteMessage 方法，并传递用户名作为参数
        echo '<a href="delete_message.php"><button class="delete-btn" onclick="deleteMessage(' . $row['username'] . ')">删除</button></a>';
    }
} else {
    // 如果没有留言记录，显示提示信息
    echo "<p>暂无留言</p>";
}

// 关闭数据库连接，释放资源
$conn->close();
?>
