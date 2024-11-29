<?php
//用于从数据库加载留言并在页面显示。
require('conndb.php');

session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} 
if (isset($_SESSION['time'])) {
    $current_time = $_SESSION['time'];
}
//准备sql语句查询留言
$sql = "delete from messages where user_username='$username' and updated_at='$current_time'";
$result = $conn->query($sql);
if ($result) {
       echo "<script>
       alert('删除成功');
       window.location.href = '欢迎来到昊斌的世界.html'
       </script>";
} else {
    "<script>
       alert('无留言');
       window.location.href = '欢迎来到昊斌的世界.html'
       </script>";
}

// 关闭数据库连接
$conn->close();
?>