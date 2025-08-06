<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Chat toggle button -->
<div id="chat-toggle" style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 1000; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);">
    <i class="fas fa-comment-dots fa-2x"></i>
</div>

<!-- Chat box -->
<div id="chat-box" style="display: none; position: fixed; bottom: 100px; right: 30px; width: 620px; height: 460px; background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); z-index: 999; display: flex; overflow: hidden; transition: all 0.3s ease; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; border: 1px solid #e5e7eb;">
    <!-- User list -->
    <div id="user-list" style="width: 30%; background: #f9fafb; overflow-y: auto; padding: 20px; border-right: 1px solid #e5e7eb;">
        <!-- User list will be added via JS -->
    </div>
    <!-- Conversation window -->
    <div id="conversation" style="width: 70%; display: flex; flex-direction: column;">
        <div style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; padding: 16px; border-radius: 0 20px 0 0; font-weight: 700; display: flex; align-items: center; font-size: 16px; position: relative;">
                   <i class="fas fa-headset fa-lg" style="margin-right: 12px;"></i> CSKH
            <button id="close-chat" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #fff; font-size: 16px; cursor: pointer; transition: all 0.3s ease;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="chat-messages" style="flex-grow: 1; padding: 20px; overflow-y: auto; background: #f3f4f6; font-size: 14px; line-height: 1.6;">
            <!-- Messages will be added via JS -->
        </div>
        <form id="chat-form" style="display: flex; border-top: 1px solid #e5e7eb; background: #fff;">
            <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." style="flex-grow: 1; padding: 12px; border: 1px solid #e5e7eb; outline: none; font-size: 14px; border-radius: 10px 0 0 10px; transition: all 0.2s ease;" />
            <button type="submit" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; border: none; padding: 12px 24px; display: flex; align-items: center; transition: all 0.3s ease; border-radius: 0 10px 10px 0;">
                <i class="fas fa-paper-plane" style="margin-right: 6px;"></i>
            </button>
        </form>
    </div>
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

/* User list styling */
#user-list div {
    display: flex;
    align-items: center;
    padding: 12px;
    margin-bottom: 12px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    cursor: pointer;
    border: 1px solid #e5e7eb;
}

#user-list div:hover {
    background: #e5e7eb;
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

#user-list div span {
    margin-left: 12px;
    font-weight: 500;
    color: #1f2937;
}

#user-list div .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    border: 1px solid #d1d5db;
}

/* Random avatar colors */
.user-avatar:nth-child(1) { background: #4a90e2; }
.user-avatar:nth-child(2) { background: #50c4b7; }
.user-avatar:nth-child(3) { background: #f5a623; }
.user-avatar:nth-child(4) { background: #e94e77; }
.user-avatar:nth-child(5) { background: #9b59b6; }
.user-avatar:nth-child(6) { background: #3498db; }
.user-avatar:nth-child(7) { background: #2ecc71; }

/* Chat messages styling */
#chat-messages p {
    margin: 8px 0;
    padding: 12px;
    border-radius: 12px;
    max-width: 75%;
    word-wrap: break-word;
    display: flex;
    flex-direction: column;
    background: #1e40af;
    color: #000;
    border: 1px solid #1e3a8a;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

#chat-messages p .message-sender {
    font-weight: bold;
    margin-bottom: 5px;
}

#chat-messages p .message-sender.admin {
    color: #dc2626;
}

#chat-messages p .message-sender.user {
    color: #2563eb;
}

#chat-messages p:nth-child(even) {
    margin-left: auto;
    text-align: right;
}

#chat-messages p:nth-child(odd) {
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
#user-list::-webkit-scrollbar,
#chat-messages::-webkit-scrollbar {
    width: 8px;
}

#user-list::-webkit-scrollbar-thumb,
#chat-messages::-webkit-scrollbar-thumb {
    background: #1e40af;
    border-radius: 10px;
}

#user-list::-webkit-scrollbar-track,
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
let selectedUserId = null;

const toggle = document.getElementById('chat-toggle');
const box = document.getElementById('chat-box');
const closeChat = document.getElementById('close-chat');
const userList = document.getElementById('user-list');
const messages = document.getElementById('chat-messages');
const form = document.getElementById('chat-form');
const input = document.getElementById('chat-input');

toggle.addEventListener('click', () => {
    box.style.display = box.style.display === 'none' || box.style.display === '' ? 'flex' : 'none';
    if (box.style.display === 'flex') {
        box.classList.add('show');
        loadUsers();
    } else {
        box.classList.remove('show');
    }
});

closeChat.addEventListener('click', () => {
    box.style.display = 'none';
    box.classList.remove('show');
});

function loadUsers() {
    fetch('?url=chat/adminFetchUsers')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                userList.innerHTML = '';
                data.users.forEach((user, index) => {
                    const div = document.createElement('div');
                    div.innerHTML = `<div class="user-avatar">${user.username.charAt(0).toUpperCase()}</div><span>${user.username}</span>`;
                    div.style.padding = '10px';
                    div.style.cursor = 'pointer';
                    div.style.borderBottom = '1px solid #eee';
                    div.addEventListener('click', () => {
                        selectedUserId = user.id;
                        loadMessages();
                    });
                    userList.appendChild(div);
                });
            } else {
                userList.innerHTML = '<p>Không thể tải danh sách người dùng</p>';
            }
        })
        .catch(err => {
            console.error('Lỗi tải danh sách người dùng:', err);
            userList.innerHTML = '<p>Lỗi kết nối</p>';
        });
}

function loadMessages() {
    if (!selectedUserId) {
        messages.innerHTML = '<p>Chọn một người dùng để xem tin nhắn</p>';
        return;
    }
    fetch(`?url=chat/adminFetchMessages&userId=${selectedUserId}`)
        .then(res => res.text())
        .then(html => {
            messages.innerHTML = html.replace(/<p>/g, '<p><span class="message-sender user">vuong</span><span class="message-content">')
                                    .replace(/<\/p>/g, '</span></p>')
                                    .replace(/admin/g, '<span class="message-sender admin">admin</span><span class="message-content">');
            messages.scrollTop = messages.scrollHeight;
        })
        .catch(err => {
            console.error('Lỗi tải tin nhắn:', err);
            messages.innerHTML = '<p>Lỗi tải tin nhắn</p>';
        });
}

form.addEventListener('submit', function(e) {
    e.preventDefault();
    if (!selectedUserId) {
        Swal.fire({ icon: 'warning', title: 'Chưa chọn người dùng', text: 'Vui lòng chọn một người dùng để gửi tin nhắn' });
        return;
    }
    const message = input.value.trim();
    if (message !== '') {
        fetch('?url=chat/adminSend', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `receiverId=${selectedUserId}&message=${encodeURIComponent(message)}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                input.value = '';
                loadMessages();
            } else {
                Swal.fire({ icon: 'error', title: 'Lỗi', text: data.message || 'Không thể gửi tin nhắn' });
            }
        })
        .catch(err => {
            console.error('Lỗi AJAX:', err);
            Swal.fire({ icon: 'error', title: 'Lỗi', text: 'Không thể kết nối đến server' });
        });
    }
});

setInterval(() => {
    if (selectedUserId && box.style.display === 'flex') {
        loadMessages();
    }
}, 2000);
</script>