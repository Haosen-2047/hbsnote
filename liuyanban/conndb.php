<?php
//指明数据库连接参数
$servername = "localhost";//数据库服务器地址
$dbUsername = "root";//数据库用户名
$dbPassword = "root";//数据用户密码
$database   = "lybdb";//数据库名称

//创建数据库连接
$conn = mysqli_connect($servername,$dbUsername,$dbPassword,$database);
mysqli_set_charset($conn, 'utf8mb4');

//检擦是否连接成功
if (!$conn){
    die("无法请求服务器：404" .mysqli_connect_error());//输出错误提醒并终止脚本执行！

}


?>