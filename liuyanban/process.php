<?php
// process.php 用于处理留言提交

// 引入数据库连接文件 conndb.php
require('conndb.php');

// 初始化一个空的响应数组，用于存储返回给客户端的数据
$response = [];

// 启动会话，允许使用 $_SESSION 超全局数组来访问会话数据
session_start();

// 检查会话中是否存在用户名
if (isset($_SESSION['username'])) {
    // 如果存在，将用户名存储到变量 $username 中
    $username = $_SESSION['username'];
}

// 检查是否通过 POST 请求发送了 message 参数
if (isset($_POST['message'])) {
    // 获取 POST 请求中的 message 参数值（用户的留言内容）
    $message = $_POST['message'];

    // 获取当前的日期和时间，并格式化为 YYYY-MM-DD HH:mm:ss
    $current_time = date("Y-m-d H:i:s");

    // 将当前时间存储到会话变量中，可能用于记录用户操作时间
    $_SESSION['time'] = $current_time;

    // 构造 SQL 语句，用于将用户名、留言内容和更新时间插入到 messages 数据表中
    $sql = "INSERT INTO messages (user_username, message, updated_at) VALUES ('$username', '$message', '$current_time')";

    // 判断 SQL 是否执行成功
    if ($conn->query($sql) === TRUE) {
        // 如果插入成功，设置响应状态为 success，并提供成功消息
        $response['status'] = 'success';
        $response['message'] = '留言成功！';
    } else {
        // 如果插入失败，设置响应状态为 error，并附带数据库错误信息
        $response['status'] = 'error';
        $response['message'] = '数据库错误：' . $conn->error;
    }
} else {
    // 如果 POST 请求中未提供 message 参数
    $response['status'] = 'error'; // 设置状态为 error
    $response['message'] = '缺少必要的参数。'; // 提示缺少参数
}

// 设置响应头为 JSON 格式，通知客户端响应内容是 JSON 数据
header('Content-Type: application/json');

// 将响应数组转换为 JSON 格式，并输出到客户端
echo json_encode($response);

// 关闭数据库连接，释放资源
$conn->close();
?>
