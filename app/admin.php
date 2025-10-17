<?php
// File: app/admin.php
require_once 'core/init.php';

if (!$is_loggedin) {
    header("location: index.php");
    exit;
}

$current_tab = $_GET['tab'] ?? 'memos';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>관리자 페이지</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <script>
        (function() {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>
</head>
<body class="font-sans">
    <div class="container mx-auto px-4 py-8">
        <?php include 'templates/partials/admin_header.php'; ?>

        <div class="mb-8 border-b border-gray-200">
            <nav class="flex items-center" aria-label="Tabs">
                <a href="?tab=memos" class="tab-link <?php if($current_tab === 'memos') echo 'active'; ?>">메모 관리</a>
                <span class="text-gray-400 dark:text-gray-600 mx-3">|</span>
                <a href="?tab=favorites" class="tab-link <?php if($current_tab === 'favorites') echo 'active'; ?>">즐겨찾기 관리</a>
                <span class="text-gray-400 dark:text-gray-600 mx-3">|</span>
                <a href="?tab=quick_links" class="tab-link <?php if($current_tab === 'quick_links') echo 'active'; ?>">빠른 링크 관리</a>
                <span class="text-gray-400 dark:text-gray-600 mx-3">|</span>
                <a href="?tab=url_shortener" class="tab-link <?php if($current_tab === 'url_shortener') echo 'active'; ?>">URL줄이기 관리</a>
            </nav>
        </div>

        <div>
            <?php
            if ($current_tab === 'memos') {
                include 'templates/admin/memos.php';
            } elseif ($current_tab === 'favorites') {
                include 'templates/admin/favorites.php';
            } elseif ($current_tab === 'quick_links') {
                include 'templates/admin/quick_links.php';
            } elseif ($current_tab === 'url_shortener') {
                // 이 곳에 URL 줄이기 관리 페이지의 콘텐츠를 추가하세요.
                echo "<div class='bg-white p-6 rounded-xl shadow-md'><p>URL 줄이기 관리 페이지입니다.</p></div>";
            }
            ?>
        </div>
    </div>
    <script src="assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
