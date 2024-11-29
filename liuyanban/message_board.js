// 获取表单元素
const form = document.getElementById('message-form'); // 获取留言表单的 DOM 元素
const submitButton = form.querySelector('button[type="submit"]'); // 获取表单中的提交按钮

// 监听表单提交事件
form.addEventListener('submit', function (event) {
    event.preventDefault(); // 阻止默认的表单提交行为，防止页面刷新

    // 禁用按钮并显示“提交中”提示
    submitButton.disabled = true; // 禁用提交按钮，避免重复提交
    submitButton.textContent = '提交中...'; // 更改按钮文本为“提交中...”
    const loadingSpinner = document.getElementById('loading-spinner'); // 获取加载动画元素
    loadingSpinner.style.display = 'inline-block'; // 显示加载动画

    // 创建表单数据
    const formData = new FormData(form); // 创建一个包含表单数据的对象

    // 提交表单到 process.php
    fetch('process.php', {
        method: 'POST', // 使用 POST 方法提交数据
        body: formData // 发送表单数据
    })
        .then(response => {
            if (!response.ok) { // 如果响应状态不是 OK，抛出错误
                throw new Error('网络响应失败');
            }
            return response.json(); // 将响应解析为 JSON 格式
        })
        .then(data => {
            console.log('响应数据:', data); // 在控制台打印响应数据，便于调试
            if (data.status === 'success') { // 如果响应状态为成功
                alert('留言成功！'); // 弹窗提示用户留言成功
                loadMessages(); // 调用函数刷新留言内容
                form.reset(); // 重置表单内容
            } else {
                alert(data.message || '留言失败！'); // 如果失败，显示错误信息
            }
        })
        .catch(error => {
            console.error('提交留言失败:', error); // 在控制台输出错误信息
            alert('提交失败，请检查网络或联系管理员！'); // 弹窗提示用户提交失败
        })
        .finally(() => {
            // 恢复按钮状态
            submitButton.disabled = false; // 启用提交按钮
            submitButton.textContent = '提交留言'; // 恢复按钮文本为“提交留言”
            loadingSpinner.style.display = 'none'; // 隐藏加载动画
        });
});

// 加载最新留言的函数
function loadMessages() {

    /*----------fetch() 方法：这是 JavaScript 的内置函数，用于向指定 URL（load_message.php）发送网络请求。
    默认情况下，它使用 HTTP GET 方法。 这行代码通过 GET 请求从服务器获取留言数据。----------------*/
    fetch('load_message.php') // 向服务器发送 GET 请求以加载留言
        .then(response => {
            if (!response.ok) { // 如果响应状态不是 OK，抛出错误
                throw new Error('无法加载留言');
            }
            return response.text(); // 将响应解析为纯文本
        })


        .then(html => {//then 是 Promise 的方法，用来处理上一步返回的解析结果。
            // 获取页面中 id 为 'messages' 的 DOM 元素(在这里是div容器)，这个元素是用来显示留言的容器
            const messagesContainer = document.getElementById('messages'); // 获取留言容器的 DOM 元素
            messagesContainer.innerHTML = html; // 将返回的 HTML 内容插入到留言容器中
        })
        .catch(error => console.error('加载留言失败:', error)); // 在控制台输出加载失败的错误信息
}

// 页面加载完成时立即加载现有留言
document.addEventListener('DOMContentLoaded', loadMessages); // 当 DOM 内容加载完成后调用加载留言函数
