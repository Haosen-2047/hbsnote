<?php
require('conndb.php');//请求连接数据库

session_start();
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
} else {
    echo "您还未登录，请先登录。";
    // 可选：重定向到登录页面
    // header("Location: login.html");
    // exit();
}

// $old_password2 = htmlspecialchars($_POST["old_password"]);
$new_password = htmlspecialchars($_POST["new_password"]); // 从表单中获取密码并清理数据
// echo $old_password;

 // 准备 SQL 语句查询用户名和密码
 $sql = "SELECT password FROM users WHERE username = '$username'"; // 使用参数化查询
 $result = $conn->query($sql); 
     // 验证查询结果
     if ($result && $result->num_rows>0) { 
        // 如果查询结果中有数据
         $row = $result->fetch_assoc(); // 获取查询结果中的第一行
         // 验证密码是否匹配
         if ($password === $row['password']) { // 比较用户输入的密码与数据库中的密码
            echo $password;
           $sql2 = "UPDATE users set password ='$new_password' where username = '$username'";//修改新密码
           $result2 = $conn->query($sql2); 
           if($result2){
            echo "<script>alert('密码修改成功！');</script>";
            echo "<script>window.location.href = 'login.html'</script>";
           }
          
          } else {
        echo "<script>alert('原密码错误！');</script>"; // 弹出用户名不存在提示
          }
}

?>