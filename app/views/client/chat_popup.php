<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Chat toggle button -->
<div id="chat-toggle" style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 1000; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);">
    <i class="fas fa-comment-dots fa-2x"></i>
</div>

<!-- Chat box -->
<div id="chat-box" style="display: none; position: fixed; bottom: 100px; right: 30px; width: 360px; height: 520px; background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); z-index: 999; display: flex; flex-direction: column; overflow: hidden; transition: all 0.3s ease; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; border: 1px solid #e5e7eb;">
    <div style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; padding: 16px; border-radius: 20px 20px 0 0; font-weight: 700; display: flex; align-items: center; font-size: 16px; position: relative;">
        <i class="fas fa-headset fa-lg" style="margin-right: 12px;"></i> CSKH
        <button id="close-chat" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #fff; font-size: 16px; cursor: pointer; transition: all 0.3s ease;">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div id="chat-messages" style="flex-grow: 1; padding: 20px; overflow-y: auto; background: #f9fafb; font-size: 14px; line-height: 1.6;">
        <!-- Messages will be added via JS -->
    </div>
    <form id="chat-form" style="display: flex; border-top: 1px solid #e5e7eb; background: #fff; padding: 8px;">
        <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." style="flex-grow: 1; padding: 12px; border: 1px solid #e5e7eb; outline: none; font-size: 14px; border-radius: 10px 0 0 10px; transition: all 0.2s ease;" />
        <button type="submit" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; border: none; padding: 12px 24px; display: flex; align-items: center; transition: all 0.3s ease; border-radius: 0 10px 10px 0;">
            <i class="fas fa-paper-plane" style="margin-right: 6px;"></i> 
        </button>
    </form>
</div>

<style>
/* Chat toggle hover effects */
#chat-toggle:hover {
    transform: scale(1.15) rotate(5deg);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    background: linear-gradient(135deg, #1e40af, #60a5fa);
}

/* Close button hover effect */
#close-chat:hover {
    transform: scale(1.2) translateY(-50%);
    color: #ff6b6b;
}

/* Chat messages styling */
#chat-messages p {
    margin: 8px 0;
    padding: 12px;
    border-radius: 12px;
    max-width: 75%;
    word-wrap: break-word;
    background: #1e40af;
    color: #000;
    border: 1px solid #1e3a8a;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

#chat-messages p.admin {
    margin-left: auto;
    text-align: right;
}

#chat-messages p.user {
    margin-right: auto;
}

#chat-messages p:hover {
    transform: scale(1.02);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

/* Input focus effect */
#chat-input:focus {
    background: #f3f4f6;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Send button hover effect */
#chat-form button:hover {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    transform: scale(1.05);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

/* Custom scrollbar */
#chat-messages::-webkit-scrollbar {
    width: 8px;
}

#chat-messages::-webkit-scrollbar-thumb {
    background: #1e40af;
    border-radius: 10px;
}

#chat-messages::-webkit-scrollbar-track {
    background: #f3f4f6;
}

/* Smooth transitions for chat box */
#chat-box {
    transform: scale(0.95);
    opacity: 0;
}

#chat-box.show {
    transform: scale(1);
    opacity: 1;
}
</style>

<script>
// Bắt đầu khối mã JavaScript.
const toggle = document.getElementById('chat-toggle');
// Lấy nút chat bằng ID.
const box = document.getElementById('chat-box');
// Lấy khung chat bằng ID.
const closeChat = document.getElementById('close-chat');
// Lấy nút đóng chat bằng ID.
const form = document.getElementById('chat-form');
// Lấy form gửi tin nhắn bằng ID.
const input = document.getElementById('chat-input');
// Lấy ô nhập tin nhắn bằng ID.
const messages = document.getElementById('chat-messages');
// Lấy vùng hiển thị tin nhắn bằng ID.

const isLoggedIn = <?= isset($_SESSION['user']['id']) ? 'true' : 'false' ?>;
// Kiểm tra nếu người dùng đã đăng nhập, gán isLoggedIn là true, ngược lại là false.

// Bấm nút 💬
toggle.addEventListener('click', () => {
    if (!isLoggedIn) {
        Swal.fire({
            icon: 'warning',
            title: 'Vui lòng đăng nhập',
            text: 'Bạn cần đăng nhập để sử dụng chức năng chat!',
            confirmButtonText: 'Đăng nhập',
        }).then(() => {
            window.location.href = '?url=client/showLoginForm';
        });
    } else {
        box.style.display = box.style.display === 'none' || box.style.display === '' ? 'flex' : 'none';
        if (box.style.display === 'flex') {
            box.classList.add('show');
            loadMessages();
        } else {
            box.classList.remove('show');
        }
    }
});

// Bấm nút đóng chat
closeChat.addEventListener('click', () => {
    box.style.display = 'none';
    box.classList.remove('show');
});

// Gửi tin nhắn qua form
form.addEventListener('submit', function(e) {
    e.preventDefault();
    const message = input.value.trim();
    if (message !== '') {
        fetch('?url=chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'message=' + encodeURIComponent(message)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                loadMessages();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: data.message || 'Không thể gửi tin nhắn',
                });
            }
        })
        .catch(err => {
            console.error('Lỗi AJAX:', err);
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Không thể kết nối đến server',
            });
        });
    }
});

// Tải lại tin nhắn
function loadMessages() {
    if (!isLoggedIn) return;
    fetch('?url=chat/fetch')
        .then(res => res.text())
        .then(html => {
            // Thêm lớp admin hoặc user dựa trên nội dung tin nhắn
            let updatedHtml = html.replace(/<p>(admin[^<]*)/gi, '<p class="admin">$1')
                                .replace(/<p>(user[^<]*)/gi, '<p class="user">$1');
            messages.innerHTML = updatedHtml;
            messages.scrollTop = messages.scrollHeight;
        })
        .catch(err => {
            console.error('Lỗi tải tin nhắn:', err);
        });
}

// Tự động tải tin nhắn nếu đã đăng nhập
if (isLoggedIn) {
    loadMessages();
    setInterval(loadMessages, 2000);
}
</script>