<?php
$pd = require('conndb.php');

// if ($_SERVER["REQUEST_METHON"] == "POST"){//判断前端的请求应用的是否为POST方法
    $username = test_input($_POST['username']);//从表单中获取用户名并清理数据
    $password = test_input($_POST['password']);
    //获取并清理用户输入，调用的是定义的一个test_input()方法
    //获取密码并清理数据

    //检查用户名和密码是否为空
    if(empty($username) || empty($password)){//判断是否为空
        echo"<script>alert('用户名和密码不能为空！')</script>";
        echo "<script>window.location.href = 'register.html'</script>";
 exit;//终止脚本执行
    }
// }

//准备Sql语句去检查用户名是否存在
$sql = "SELECT * FROM users where username = '$username'";
$result = mysqli_query($conn,$sql);//执行查询；
//如果用户名已存在就提示！
if(mysqli_num_rows($result) > 0){
    echo"<script>alert('用户已经存在！')</script>";
    echo "<script>window.location.href = 'register.html'</script>";
    //插入新的用户名和密码
    }else{
        $sql = "insert into users (username,password) values ('$username','$password')";
        $result=$conn->query($sql);
        if($result===TRUE){
        echo "<script>alert('注册成功');</script>";
        echo "<script>window.location.href = 'login.html'</script>";
        
        }else{
        echo"<script>alert('错误: " . mysqli_error($conn) . "');</script>"; // 如果插入失败，显示数据库错误信息
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