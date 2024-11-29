<?php
require('conndb.php');
session_start();

// 检查是否通过 POST 方法提交
if ($_SERVER["REQUEST_METHOD"] == "POST") { // 判断请求是否为 POST 方法

    // 获取并清理用户输入
    $username = test_input($_POST["username"]); // 从表单中获取用户名并清理数据
    $password = test_input($_POST["password"]); // 从表单中获取密码并清理数据
    $_SESSION['username']=$username;//通过超全局变量$_SESSION拿到$username
    $_SESSION['password']=$password;
    // 检查用户名和密码是否为空
    if (empty($username) || empty($password)) { // 如果用户名或密码为空
        echo "<script>alert('用户名或密码不能为空');</script>"; // 弹出提示框
        exit; // 终止脚本执行
    }

    // 准备 SQL 语句查询用户名和密码
    // $sql = "SELECT password FROM lyb_user WHERE username = '$username'"; // 查询用户名对应的密码
    // $stmt = $conn->query($sql); // 准备 SQL 语句


    // 准备 SQL 语句查询用户名和密码
$sql = "SELECT password FROM users WHERE username = ?"; // 使用参数化查询
$stmt = $conn->prepare($sql); // 准备 SQL 语句

// 绑定参数
$stmt->bind_param("s", $username); // "s" 表示参数类型为字符串

// 执行查询
$stmt->execute();
$result = $stmt->get_result(); // 获取查询结果


    // 验证查询结果
    if ($result&&$result->num_rows > 0) { // 如果查询结果中有数据
        $row = $result->fetch_assoc(); // 获取查询结果中的第一行
        // 验证密码是否匹配
        if ($password === $row['password']) { // 比较用户输入的密码与数据库中的密码
            echo "<script>alert('登录成功！');</script>"; // 弹出成功提示
            echo "<script>window.location.href = '欢迎来到昊斌的世界.html'</script>"; // 跳转到欢迎页面
        } else {
            echo "<script>alert('密码错误！');</script>"; // 弹出密码错误提示
            echo "<script>window.location.href = 'login.html'</script>"; // 
        }
    } else {
        echo "<script>alert('用户名不存在！');</script>"; // 弹出用户名不存在提示
        echo "<script>window.location.href = 'register.html'</script>"; 
    }
}
    $result->close(); // 关闭预处理语句

$conn->close(); // 关闭数据库连接

// 数据清理函数
function test_input($data) {
    $data = trim($data); // 去除字符串两端的空格
    $data = stripslashes($data); // 去除字符串中的反斜杠
    $data = htmlspecialchars($data); // 将 HTML 特殊字符转义
    return $data; // 返回清理后的数据
}
?>
