<?php
require_once __DIR__ . '/../models/Message.php';

class ChatController extends Controller
{
    public function send()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user']['id'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
            exit;
        }
        $msg = new Message();
        $message = trim($_POST['message'] ?? '');
        $senderId = (int)$_SESSION['user']['id'];
        $receiverId = 1; // Admin có ID = 1
        if (!empty($message)) {
            $success = $msg->sendMessage($senderId, $receiverId, $message);
            echo json_encode(['success' => $success, 'message' => $success ? 'Gửi thành công' : 'Lỗi khi gửi']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Tin nhắn không được để trống']);
        }
        exit;
    }
public function fetch()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user']['id'])) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
        exit;
    }
    $userId = (int)$_SESSION['user']['id'];
    $msg = new Message();

    // Đánh dấu tất cả tin nhắn từ admin (ID=1) đến người dùng này là đã xem
    $msg->markAsSeen($userId, 1);

    $messages = $msg->getMessages($userId);
    $output = '';
    foreach ($messages as $m) {
        $isMe = $m['sender_id'] == $userId;
        $timeSent = date('H:i', strtotime($m['created_at']));
        // Chuẩn bị dòng trạng thái đã xem, chỉ hiển thị cho tin nhắn do người dùng gửi và đã được admin xem
        $seenLine = '';
        if ($isMe && !empty($m['seen_at'])) {
            $seenTime = date('H:i', strtotime($m['seen_at']));
            $seenLine = '<div style="font-size:0.7em;color:#999;">' . htmlspecialchars($m['receiver_username']) . ' đã xem lúc ' . $seenTime . '</div>';
        }
        $output .= '<div style="margin-bottom: 5px; text-align:' . ($isMe ? 'right' : 'left') . ';">
            <span style="font-size:0.8em; color:#666;">' . htmlspecialchars($m['sender_username']) . '</span><br>
            <span style="background:' . ($isMe ? '#007bff' : '#007bff') . '; padding: 5px 10px; border-radius: 15px; color:white; display:inline-block; max-width:80%; word-wrap:break-word;">
                ' . htmlspecialchars($m['message'], ENT_QUOTES, 'UTF-8') . '
            </span>
            <div style="font-size:0.7em;color:#999;">' . $timeSent . '</div>
            ' . $seenLine . '
        </div>';
    }
    echo $output;
    exit;
}
    // public function fetch()
    // {
    //     if (session_status() === PHP_SESSION_NONE) {
    //         session_start();
    //     }
    //     if (!isset($_SESSION['user']['id'])) {
    //         echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
    //         exit;
    //     }
    //     $userId = (int)$_SESSION['user']['id'];
    //     $msg = new Message();

    //     // ADD: Đánh dấu tất cả tin nhắn từ admin (ID=1) đến user này là đã xem
    //     $msg->markAsSeen($userId, 1);

    //     $messages = $msg->getMessages($userId);
    //     $output = '';
    //     foreach ($messages as $m) {
    //         $isMe = $m['sender_id'] == $userId;
    //         $timeSent = date('H:i', strtotime($m['created_at']));
    //         // ADD: Lấy thời gian seen nếu có
    //         $seenLine = '';
    //         if (!$isMe && !empty($m['seen_at'])) {
    //             $seenTime = date('H:i', strtotime($m['seen_at']));
    //             $seenLine = '<div style="font-size:0.7em;color:#999;">Đã xem lúc ' . $seenTime . '</div>';
    //         }
    //         $output .= '<div style="margin-bottom: 5px; text-align:' . ($isMe ? 'right' : 'left') . ';">
    //             <span style="font-size:0.8em; color:#666;">' . htmlspecialchars($m['username']) . '</span><br>
    //             <span style="background:' . ($isMe ? '#007bff' : '#007bff') . '; padding: 5px 10px; border-radius: 15px; color:white; display:inline-block; max-width:80%; word-wrap:break-word;">
    //                 ' . htmlspecialchars($m['message'], ENT_QUOTES, 'UTF-8') . '
    //             </span>
    //             <div style="font-size:0.7em;color:#999;">' . $timeSent . '</div>
    //             ' . $seenLine . '
    //         </div>';
    //     }
    //     echo $output;
    //     exit;
    // }

    // Lấy danh sách người dùng đã nhắn tin với admin
    public function adminFetchUsers()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Kiểm tra nếu admin chưa đăng nhập
        if (!isset($_SESSION['admin'])) {
            echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập']);
            exit;
        }
        $msg = new Message();
        $users = $msg->getUsersWithMessages();
        echo json_encode(['success' => true, 'users' => $users]);
        exit;
    }

    // Lấy tin nhắn giữa admin và một người dùng cụ thể
public function adminFetchMessages()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['admin'])) {
        echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập']);
        exit;
    }
    $userId = $_GET['userId'] ?? null;
    if (!$userId) {
        echo json_encode(['success' => false, 'message' => 'Chưa chọn người dùng']);
        exit;
    }
    $msg = new Message();

    // Đánh dấu tất cả tin nhắn từ người dùng này đến admin (ID=1) là đã xem
    $msg->markAsSeen(1, $userId);

    $messages = $msg->getMessages($userId);
    $output = '';
    foreach ($messages as $m) {
        $isMe = $m['sender_id'] == 1;
        $timeSent = date('H:i', strtotime($m['created_at']));
        // Chuẩn bị dòng trạng thái đã xem, chỉ hiển thị cho tin nhắn do admin gửi và đã được người dùng xem
        $seenLine = '';
        if ($isMe && !empty($m['seen_at'])) {
            $seenTime = date('H:i', strtotime($m['seen_at']));
            $seenLine = '<div style="font-size:0.7em;color:#999;">' . htmlspecialchars($m['receiver_username']) . ' đã xem lúc ' . $seenTime . '</div>';
        }
        $output .= '<div style="margin-bottom: 5px; text-align:' . ($isMe ? 'right' : 'left') . ';">
            <span style="font-size:0.8em; color:#666;">' . htmlspecialchars($m['sender_username']) . '</span><br>
            <span style="background:' . ($isMe ? '#007bff' : '#007bff') . '; padding: 5px 10px; border-radius: 15px; color:white; display:inline-block; max-width:80%; word-wrap:break-word;">
                ' . htmlspecialchars($m['message'], ENT_QUOTES, 'UTF-8') . '
            </span>
            <div style="font-size:0.7em;color:#999;">' . $timeSent . '</div>
            ' . $seenLine . '
        </div>';
    }
    echo $output;
    exit;
}
    // Gửi tin nhắn từ admin đến người dùng
    public function adminSend()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['admin'])) {
            echo json_encode(['success' => false, 'message' => 'Không có quyền truy cập']);
            exit;
        }
        $receiverId = $_POST['receiverId'] ?? null;
        $message = trim($_POST['message'] ?? '');
        if (!$receiverId || empty($message)) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin cần thiết']);
            exit;
        }
        $msg = new Message();
        $success = $msg->sendMessage(1, $receiverId, $message);
        echo json_encode(['success' => $success, 'message' => $success ? 'Gửi thành công' : 'Lỗi khi gửi']);
        exit;
    }
}
