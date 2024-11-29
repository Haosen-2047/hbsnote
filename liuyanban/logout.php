<?php
// 启动会话
session_start();

// 销毁会话数据
session_unset(); // 清空会话中的所有数据
session_destroy(); // 销毁会话

// 重定向到登录页面
header("Location: login.html");
exit();
?>
