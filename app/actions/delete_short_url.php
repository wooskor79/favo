<?php
// File: app/actions/delete_short_url.php
require_once '../core/init.php';

if (!$is_loggedin) {
    header("location: ../index.php");
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    // Shortener DB에 연결
    $shortener_db_name = 'shortener';
    $conn_shortener = new mysqli($db_host, $db_user, $db_pass, $shortener_db_name);
    
    if (!$conn_shortener->connect_error) {
        $stmt = $conn_shortener->prepare("DELETE FROM links WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "단축 URL이 삭제되었습니다.";
        } else {
            $_SESSION['error'] = "삭제에 실패했습니다: " . $conn_shortener->error;
        }
        $stmt->close();
        $conn_shortener->close();
    } else {
        $_SESSION['error'] = "Shortener 데이터베이스 연결에 실패했습니다.";
    }
}

header("location: ../admin.php?tab=url_shortener");
exit;
?>