<h2>💬 Hỗ trợ khách hàng</h2>
<div class="row justify-content-center">
    <div class="col-3">
        <h5>Khách hàng</h5>
        <ul id="user-list" class="list-group"></ul>
    </div>
    <div class="col-9">
        <div id="chat-box" class="mx-auto" style="height: 400px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; background: #fff; max-width: 100%;">
        </div>
        <form id="chat-form" class="mt-2 d-flex">
            <input type="text" class="form-control me-2" id="message" placeholder="Nhập tin nhắn..." required>
            <button type="submit" class="btn btn-primary">Gửi</button>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script>
    let selectedUserId = null;

    function loadUsers() {
        $.get('?url=chat/adminFetchUsers', function(res) {
            const data = JSON.parse(res);
            if (data.success) {
                $('#user-list').empty();
                data.users.forEach(u => {
                    $('#user-list').append(`<li class="list-group-item user-item" data-id="${u.id}" style="cursor:pointer">${u.username}</li>`);
                });
            }
        });
    }

    function loadMessages(userId) {
        $.get('?url=chat/adminFetchMessages&userId=' + userId, function(res) {
            $('#chat-box').html(res);
        });
    }

    $(document).ready(function() {
        loadUsers();

        $(document).on('click', '.user-item', function() {
            selectedUserId = $(this).data('id');
            $('.user-item').removeClass('active');
            $(this).addClass('active');
            loadMessages(selectedUserId);
        });

        $('#chat-form').on('submit', function(e) {
            e.preventDefault();
            if (!selectedUserId) return;
            const msg = $('#message').val();
            $.post('?url=chat/adminSend', {
                receiverId: selectedUserId,
                message: msg
            }, function(res) {
                $('#message').val('');
                loadMessages(selectedUserId);
            });
        });

        let lastLoadedAt = Date.now();

        setInterval(() => {
            if (selectedUserId) {
                // Chỉ fetch nếu người dùng đang tương tác hoặc gần đây có tin nhắn
                const now = Date.now();
                if (now - lastLoadedAt < 30000) {
                    loadMessages(selectedUserId);
                }
            }
        }, 10000); // Mỗi 10s

    });
</script>