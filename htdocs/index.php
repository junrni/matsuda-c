<?php
session_start(); // セッション開始を追加

// データベース接続関数 (db.phpに分離)
require 'db.php';

// HTMLエスケープ関数 (一度だけ定義)
function h($var) {
    if (is_array($var)) {
        return array_map('h', $var);
    } else {
        return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
    }
}

// HTMLヘッダーとCSS出力関数
function print_header($title) {
    echo '<!DOCTYPE html><html lang="ja"><head><meta charset="UTF-8">';
    echo "<title>{$title}</title>";
    echo '<style>
        body { font-family: "Hiragino Maru Gothic Pro", sans-serif; background: #fff0f5; color: #333; padding: 20px; }
        h2, h3 { color: #d66ba0; }
        form { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #eee; }
        input, button { margin: 10px 0; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        input[type="text"], input[type="password"], input[type="date"], input[type="time"] { width: 100%; max-width: 300px; }
        button { background-color: #ff99cc; color: white; cursor: pointer; }
        button:hover { background-color: #ff66aa; }
        a { margin-right: 10px; color: #d66ba0; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .message { padding: 10px; margin: 10px 0; background: #ffe0ec; border-left: 5px solid #d66ba0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ff99cc; padding: 8px; text-align: left; }
        th { background-color: #ffe0ec; }
    </style></head><body>';
}

function print_footer() {
    echo '</body></html>';
}

// ログイン処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_number'], $_POST['password'])) {
    $stmt = $db->prepare('SELECT * FROM mst_students WHERE student_number = ? AND password = ?');
    $stmt->execute([$_POST['student_number'], $_POST['password']]);
    $user = $stmt->fetch();
    
    if ($user) {
        $_SESSION['student_number'] = $user['student_number'];
        header('Location: index.php');
        exit;
    } else {
        print_header('ログインエラー');
        echo "<div class='message'>ログインに失敗しました</div>";
        print_footer();
        exit;
    }
}

// 未ログイン時のログインフォーム表示
if (!isset($_SESSION['student_number'])) {
    print_header('ログイン');
    echo '<h2>ログイン</h2><form method="POST">';
    echo '受講者番号: <input type="text" name="student_number" required><br>';
    echo 'パスワード: <input type="password" name="password" required><br>';
    echo '<button type="submit">ログイン</button></form>';
    print_footer();
    exit;
}

// ログアウト処理
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

// ログイン後のメイン画面
print_header('ダッシュボード');
echo "<h2>ようこそ {$_SESSION['student_number']} さん</h2>";
echo '<a href="?page=reserve">予約する</a> | ';
echo '<a href="?page=confirm">予約確認</a> | ';
echo '<a href="?page=delete">予約削除</a> | ';
echo '<a href="?logout">ログアウト</a><hr>';

// 予約処理
if (isset($_GET['page']) && $_GET['page'] === 'reserve') {
    echo '<h3>予約画面</h3>';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $db->prepare('SELECT COUNT(*) FROM comments WHERE lesson_date = ? AND lesson_time = ?');
        $stmt->execute([$_POST['date'], $_POST['time']]);
        
        if ($stmt->fetchColumn() == 0) {
            $stmt = $db->prepare('INSERT INTO comments (lesson_date, lesson_time, teacher_name, lesson_type, student_number) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([
                $_POST['date'], $_POST['time'], $_POST['teacher'], $_POST['type'], $_SESSION['student_number']
            ]);
            echo "<div class='message'>予約が完了しました</div>";
        } else {
            echo "<div class='message'>満枠です。他の時間を選んでください</div>";
        }
    }
    
    echo '<form method="POST">';
    echo '日付: <input type="date" name="date" required><br>';
    echo '時間: <input type="time" name="time" required><br>';
    echo '講師名: <input type="text" name="teacher"><br>';
    echo 'レッスン種別: <input type="text" name="type"><br>';
    echo '<button type="submit">予約</button></form>';
}

// 予約確認処理
if (isset($_GET['page']) && $_GET['page'] === 'confirm') {
    echo '<h3>予約確認</h3>';
    $stmt = $db->prepare('SELECT * FROM comments WHERE student_number = ?');
    $stmt->execute([$_SESSION['student_number']]);
    
    if ($stmt->rowCount() > 0) {
        echo '<table>';
        echo '<tr><th>日付</th><th>時間</th><th>講師</th><th>種別</th></tr>';
        foreach ($stmt as $row) {
            echo '<tr>';
            echo '<td>' . h($row['lesson_date']) . '</td>';
            echo '<td>' . h($row['lesson_time']) . '</td>';
            echo '<td>' . h($row['teacher_name']) . '</td>';
            echo '<td>' . h($row['lesson_type']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<div class="message">予約はありません</div>';
    }
}

// 予約削除処理
if (isset($_GET['page']) && $_GET['page'] === 'delete') {
    echo '<h3>予約削除</h3>';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $db->prepare('DELETE FROM comments WHERE student_number = ? AND lesson_date = ? AND lesson_time = ?');
        $stmt->execute([
            $_SESSION['student_number'], $_POST['date'], $_POST['time']
        ]);
        
        if ($stmt->rowCount() > 0) {
            echo '<div class="message">予約を削除しました</div>';
        } else {
            echo '<div class="message">該当する予約が見つかりません</div>';
        }
    }
    
    // 予約一覧を表示
    $stmt = $db->prepare('SELECT * FROM comments WHERE student_number = ?');
    $stmt->execute([$_SESSION['student_number']]);
    
    if ($stmt->rowCount() > 0) {
        echo '<form method="POST">';
        echo '<table>';
        echo '<tr><th>選択</th><th>日付</th><th>時間</th><th>講師</th><th>種別</th></tr>';
        
        foreach ($stmt as $row) {
            echo '<tr>';
            echo '<td><input type="radio" name="delete_id" value="' . h($row['id']) . '"></td>';
            echo '<td>' . h($row['lesson_date']) . '</td>';
            echo '<td>' . h($row['lesson_time']) . '</td>';
            echo '<td>' . h($row['teacher_name']) . '</td>';
            echo '<td>' . h($row['lesson_type']) . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        echo '<button type="submit">選択した予約を削除</button>';
        echo '</form>';
    } else {
        echo '<div class="message">削除可能な予約がありません</div>';
    }
}

print_footer();
?>