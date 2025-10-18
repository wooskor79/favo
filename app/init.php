<?php
// File: app/core/init.php

// =============== 1. 기본 설정 ===============
session_start();


// =============== 2. 데이터베이스 연결 ===============
$db_host = 'common_database_server';
$db_name = 'favorites_db';
$db_user = 'root';
$db_pass = 'dldntjd@D79';

// 메인 DB 연결
$conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Shortener DB 연결을 위한 함수 (새로 추가 및 수정)
function get_shortener_db_connection() {
    global $db_host, $db_user, $db_pass;
    $shortener_db_name = 'shortener';
    
    $conn_shortener = new mysqli($db_host, $db_user, $db_pass, $shortener_db_name);

    if ($conn_shortener->connect_error) {
        return null; // 연결 실패 시 null 반환
    }
    $conn_shortener->set_charset("utf8mb4");
    return $conn_shortener;
}


// =============== 3. 데이터 조회 ===============

// 즐겨찾기 목록
$favorites = [];
$fav_result = $conn->query("SELECT * FROM favorites ORDER BY created_at DESC");
if ($fav_result) {
    while($row = $fav_result->fetch_assoc()) {
        $favorites[] = $row;
    }
}

// 메모 목록
$memos = [];
$memo_result = $conn->query("SELECT id, title, content, images, created_at FROM memos ORDER BY created_at DESC");
if ($memo_result) {
    while($row = $memo_result->fetch_assoc()) {
        $memos[] = $row;
    }
}

// 빠른 링크 목록
$quick_links = [];
$quick_links_result = $conn->query("SELECT * FROM quick_links ORDER BY created_at ASC");
if ($quick_links_result) {
    while($row = $quick_links_result->fetch_assoc()) {
        $quick_links[] = $row;
    }
}

// =============== 4. 변수 설정 ===============
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

$is_loggedin = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;


// =============== 5. URL 단축기(Shortener) 연동 (수정됨) ===============
$shortener_links = [];
if ($is_loggedin && basename($_SERVER['PHP_SELF']) == 'admin.php' && ($_GET['tab'] ?? '') === 'url_shortener') {
    $conn_shortener = get_shortener_db_connection(); // 함수 사용
    if ($conn_shortener) {
        $search_query = $_GET['q'] ?? '';
        $sql = "SELECT * FROM links WHERE code IS NOT NULL";
        if (!empty($search_query)) {
            $sql .= " AND (code LIKE '%" . $conn_shortener->real_escape_string($search_query) . "%' OR title LIKE '%" . $conn_shortener->real_escape_string($search_query) . "%')";
        }
        $sql .= " ORDER BY id DESC";
        
        $shortener_result = $conn_shortener->query($sql);
        if ($shortener_result) {
            while($row = $shortener_result->fetch_assoc()) {
                $shortener_links[] = $row;
            }
        }
        $conn_shortener->close();
    }
}
?>