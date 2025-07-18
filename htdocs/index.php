<<<<<<< HEAD:htdocs/index.php
<?php
session_start(); // セッション開始

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
=======
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ピアノレッスン予約システム</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ffeef8 0%, #f0e6ff 100%);
            min-height: 100vh;
            color: #5a4b7c;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #8b5fb5;
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(139, 95, 181, 0.2);
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(139, 95, 181, 0.2);
            margin-bottom: 20px;
            border: 3px solid #e8d5f2;
        }

        .login-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #8b5fb5;
        }

        input[type="text"], input[type="password"], input[type="date"], select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e8d5f2;
            border-radius: 10px;
            font-size: 16px;
            background: #ffffff;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, input[type="password"]:focus, input[type="date"]:focus, select:focus {
            outline: none;
            border-color: #8b5fb5;
            box-shadow: 0 0 10px rgba(139, 95, 181, 0.3);
        }

        .btn {
            background: linear-gradient(45deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 10px;
            box-shadow: 0 5px 15px rgba(255, 154, 158, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 154, 158, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(45deg, #a8e6cf 0%, #dcedc1 100%);
            color: #5a4b7c;
        }

        .btn-danger {
            background: linear-gradient(45deg, #ffb3ba 0%, #ffdfba 100%);
        }

        .btn-small {
            padding: 8px 16px;
            font-size: 14px;
            margin: 5px;
        }

        .teacher-section {
            background: linear-gradient(135deg, #f8f4ff 0%, #e8d5f2 100%);
            padding: 20px;
            border-radius: 15px;
            border: 3px solid #8b5fb5;
            margin-bottom: 30px;
            text-align: center;
        }

        .piano-icon {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .booking-section {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .calendar-section {
            flex: 1;
            min-width: 400px;
        }

        .bookings-section {
            flex: 1;
            min-width: 350px;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .calendar-nav {
            background: #8b5fb5;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
        }

        .calendar-nav:hover {
            background: #7a4fa3;
        }

        .calendar-month {
            font-size: 1.5em;
            font-weight: bold;
            color: #8b5fb5;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
            border: 2px solid transparent;
            position: relative;
        }

        .calendar-day.weekday-name {
            background: #8b5fb5;
            color: white;
            cursor: default;
            font-size: 0.9em;
        }

        .calendar-day.available {
            background: #d4f8d4;
            color: #2d5a2d;
            border-color: #a8e6cf;
        }

        .calendar-day.available:hover {
            background: #a8e6cf;
            transform: scale(1.1);
        }

        .calendar-day.fully-booked {
            background: #ffb3ba;
            color: #8b4545;
            cursor: not-allowed;
            border-color: #ff9a9e;
        }

        .calendar-day.fully-booked::after {
            content: '満';
            position: absolute;
            top: 2px;
            right: 2px;
            font-size: 0.7em;
            background: #ff6b6b;
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .calendar-day.selected {
            background: #ff9a9e;
            color: white;
            border-color: #8b5fb5;
            transform: scale(1.1);
        }

        .calendar-day.other-month {
            color: #ccc;
            cursor: default;
        }

        .time-slots {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            margin-bottom: 20px;
        }

        .time-slot {
            padding: 10px;
            background: #d4f8d4;
            border: 2px solid #a8e6cf;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        .time-slot:hover {
            background: #a8e6cf;
            transform: translateY(-2px);
        }

        .time-slot.selected {
            background: #ff9a9e;
            color: white;
            border-color: #8b5fb5;
        }

        .time-slot.booked {
            background: #ffb3ba;
            color: #7a4fa3;
            cursor: not-allowed;
        }

        .time-slot.already-booked {
            background: #e0e0e0;
            color: #888;
            cursor: not-allowed;
            border-color: #bbb;
        }

        .time-slot.already-booked::after {
            content: '予約済み';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.8em;
            background: #888;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
        }

        .screen {
            display: none;
        }

        .screen.active {
            display: block;
        }

        .error-message {
            background: #ffb3ba;
            color: #8b5fb5;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 2px solid #ff9a9e;
        }

        .success-message {
            background: #d4f8d4;
            color: #2d5a2d;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 2px solid #a8e6cf;
        }

        .lesson-info {
            background: #f8f4ff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 2px solid #e8d5f2;
        }

        .booking-list {
            max-height: 400px;
            overflow-y: auto;
            border: 2px solid #e8d5f2;
            border-radius: 10px;
            padding: 15px;
        }

        .booking-item {
            background: #ffffff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            border: 2px solid #e8d5f2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .booking-item:hover {
            border-color: #8b5fb5;
            transform: translateY(-2px);
        }

        .booking-details {
            flex: 1;
        }

        .booking-date {
            font-weight: bold;
            color: #8b5fb5;
            margin-bottom: 5px;
        }

        .booking-time {
            color: #5a4b7c;
            font-size: 0.9em;
        }

        .no-bookings {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .booking-section {
                flex-direction: column;
            }
            
            .calendar-section,
            .bookings-section {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎹 ピアノレッスン予約システム</h1>
        </div>

        <!-- ログイン画面 -->
        <div id="loginScreen" class="screen active">
            <div class="card">
                <div class="login-form">
                    <h2 style="text-align: center; margin-bottom: 30px; color: #8b5fb5;">ログイン</h2>
                    <div class="form-group">
                        <label for="studentId">受講者番号（7桁）</label>
                        <input type="text" id="studentId" maxlength="7" placeholder="1234567">
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" id="password" maxlength="36" placeholder="パスワードを入力">
                    </div>
                    <div style="text-align: center;">
                        <button class="btn" onclick="login()">ログイン</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ログインエラー画面 -->
        <div id="loginErrorScreen" class="screen">
            <div class="card">
                <div class="error-message">
                    <h3 style="text-align: center;">ログインエラー</h3>
                    <p style="text-align: center; margin-top: 10px;">受講者番号またはパスワードが正しくありません。</p>
                </div>
                <div style="text-align: center;">
                    <button class="btn" onclick="showScreen('loginScreen')">戻る</button>
                </div>
            </div>
        </div>

        <!-- 予約画面（講師情報統合） -->
        <div id="bookingScreen" class="screen">
            <div class="card">
                <h2 style="text-align: center; margin-bottom: 30px; color: #8b5fb5;">レッスン予約</h2>
                
                <!-- 講師情報 -->
                <div class="teacher-section">
                    <div class="piano-icon">🎹</div>
                    <h3 style="color: #8b5fb5; margin-bottom: 10px;">田中先生</h3>
                    <p style="margin-bottom: 10px;">🎵 クラシック・ポピュラー対応</p>
                    <p style="margin-bottom: 10px;">📚 初心者から上級者まで</p>
                    <p style="color: #666; font-size: 0.9em;">経験豊富な講師です</p>
                </div>
>>>>>>> e23d73c179664ab082cd0e37a74bbf0e88483c38:htdocs/index.html

                <div class="booking-section">
                    <!-- カレンダー・予約セクション -->
                    <div class="calendar-section">
                        <h3 style="color: #8b5fb5; margin-bottom: 15px;">📅 新しい予約</h3>
                        
                        <div class="calendar-header">
                            <button class="calendar-nav" onclick="changeMonth(-1)">◀</button>
                            <div class="calendar-month" id="currentMonth"></div>
                            <button class="calendar-nav" onclick="changeMonth(1)">▶</button>
                        </div>

<<<<<<< HEAD:htdocs/index.php
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
=======
                        <div class="calendar" id="calendar"></div>

                        <div id="timeSlotSection" style="display: none;">
                            <h4 style="color: #8b5fb5; margin-bottom: 15px;">時間選択</h4>
                            <div class="time-slots" id="timeSlots"></div>
                        </div>

                        <div style="text-align: center;">
                            <button class="btn" id="confirmBooking" onclick="confirmBooking()" style="display: none;">予約確定</button>
                        </div>
                    </div>

                    <!-- 予約一覧セクション -->
                    <div class="bookings-section">
                        <h3 style="color: #8b5fb5; margin-bottom: 15px;">📋 予約一覧</h3>
                        <div class="booking-list" id="bookingList">
                            <div class="no-bookings">予約がありません</div>
                        </div>
                        <div style="text-align: center; margin-top: 20px;">
                            <button class="btn btn-secondary" onclick="logout()">ログアウト</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 予約確認画面 -->
        <div id="confirmationScreen" class="screen">
            <div class="card">
                <div class="success-message">
                    <h3 style="text-align: center;">予約が完了しました！</h3>
                </div>
                
                <div class="lesson-info">
                    <h4 style="color: #8b5fb5; margin-bottom: 15px;">予約詳細</h4>
                    <p><strong>講師:</strong> <span id="confirmedTeacher"></span></p>
                    <p><strong>日時:</strong> <span id="confirmedDateTime"></span></p>
                    <p><strong>受講者番号:</strong> <span id="confirmedStudentId"></span></p>
                </div>
                
                <div style="text-align: center;">
                    <button class="btn" onclick="showScreen('bookingScreen')">戻る</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // グローバル変数
        let currentUser = null;
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTime = null;
        let selectedTeacher = '田中先生';

        // サンプルデータ
        const users = {
            '1234567': { password: 'password123', name: '山田太郎' },
            '2345678': { password: 'mypassword', name: '佐藤花子' },
            '3456789': { password: 'lesson2024', name: '田中次郎' }
        };

        // 予約データ（受講者別）
        let userBookings = {};

        // 利用可能な時間スロット
        const timeSlots = [
            '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00'
        ];

        // 日付を文字列に変換（タイムゾーンを考慮）
        function dateToString(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // 文字列を日付に変換
        function stringToDate(dateStr) {
            const parts = dateStr.split('-');
            const year = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10) - 1; // 月は0ベース
            const day = parseInt(parts[2], 10);
            return new Date(year, month, day);
        }

        // 日付を表示用の文字列に変換する関数
        function formatDate(date) {
            return `${date.getFullYear()}年${date.getMonth() + 1}月${date.getDate()}日`;
        }

        // 日付が今日以降かチェック
        function isDateAvailable(date) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const checkDate = new Date(date);
            checkDate.setHours(0, 0, 0, 0);
            return checkDate >= today;
        }

        // 画面切り替え
        function showScreen(screenId) {
            document.querySelectorAll('.screen').forEach(screen => {
                screen.classList.remove('active');
            });
            document.getElementById(screenId).classList.add('active');
            
            if (screenId === 'bookingScreen') {
                renderCalendar();
                renderBookingList();
            }
        }

        // ログイン処理
        function login() {
            const studentId = document.getElementById('studentId').value;
            const password = document.getElementById('password').value;

            if (users[studentId] && users[studentId].password === password) {
                currentUser = { id: studentId, name: users[studentId].name };
                
                // ユーザーの予約データを初期化
                if (!userBookings[studentId]) {
                    userBookings[studentId] = {};
                }
                
                showScreen('bookingScreen');
            } else {
                showScreen('loginErrorScreen');
            }
        }

        // カレンダー表示
        function renderCalendar() {
            const calendar = document.getElementById('calendar');
            const monthElement = document.getElementById('currentMonth');
            
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            monthElement.textContent = `${year}年${month + 1}月`;
            
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());
            
            calendar.innerHTML = '';
            
            // 曜日ヘッダー
            const weekdays = ['日', '月', '火', '水', '木', '金', '土'];
            weekdays.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.classList.add('calendar-day', 'weekday-name');
                dayElement.textContent = day;
                calendar.appendChild(dayElement);
            });
            
            // 日付
            for (let i = 0; i < 42; i++) {
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);
                
                const dayElement = document.createElement('div');
                dayElement.classList.add('calendar-day');
                dayElement.textContent = date.getDate();
                
                if (date.getMonth() !== month) {
                    dayElement.classList.add('other-month');
                } else if (isDateAvailable(date)) {
                    const dateStr = dateToString(date);
                    const bookedSlots = getAllBookedSlots(dateStr);
                    
                    if (bookedSlots.length >= timeSlots.length) {
                        dayElement.classList.add('fully-booked');
                    } else {
                        dayElement.classList.add('available');
                        dayElement.onclick = () => selectDate(date);
                    }
                }
                
                calendar.appendChild(dayElement);
            }
        }

        // 指定日の全体の予約済みスロットを取得（全ユーザー）
        function getAllBookedSlots(dateStr) {
            const allUsersBookings = Object.values(userBookings);
            const bookedSlots = [];
            
            allUsersBookings.forEach(userBooking => {
                if (userBooking[dateStr]) {
                    bookedSlots.push(...userBooking[dateStr]);
                }
            });
            
            return bookedSlots;
        }

        // 指定日の現在ユーザーの予約済みスロットを取得
        function getCurrentUserBookedSlots(dateStr) {
            const userBookingData = userBookings[currentUser.id] || {};
            return userBookingData[dateStr] || [];
        }

        // 日付選択
        function selectDate(date) {
            selectedDate = date;
            document.querySelectorAll('.calendar-day.selected').forEach(day => {
                day.classList.remove('selected');
            });
            event.target.classList.add('selected');
            
            renderTimeSlots();
            document.getElementById('timeSlotSection').style.display = 'block';
        }

        // 時間スロット表示
        function renderTimeSlots() {
            const timeSlotsContainer = document.getElementById('timeSlots');
            const dateStr = dateToString(selectedDate);
            const allBookedSlots = getAllBookedSlots(dateStr);
            const currentUserBookedSlots = getCurrentUserBookedSlots(dateStr);
            
            timeSlotsContainer.innerHTML = '';
            
            timeSlots.forEach(time => {
                const slot = document.createElement('div');
                slot.classList.add('time-slot');
                slot.textContent = time;
                
                if (currentUserBookedSlots.includes(time)) {
                    // 現在のユーザーが既に予約している時間
                    slot.classList.add('already-booked');
                    slot.style.position = 'relative';
                } else if (allBookedSlots.includes(time)) {
                    // 他のユーザーが予約している時間
                    slot.classList.add('booked');
                } else {
                    // 予約可能な時間
                    slot.onclick = () => selectTime(time);
                }
                
                timeSlotsContainer.appendChild(slot);
            });
        }

        // 時間選択
        function selectTime(time) {
            selectedTime = time;
            document.querySelectorAll('.time-slot.selected').forEach(slot => {
                slot.classList.remove('selected');
            });
            event.target.classList.add('selected');
            
            document.getElementById('confirmBooking').style.display = 'inline-block';
        }

        // 予約確定
        function confirmBooking() {
            if (!selectedDate || !selectedTime) {
                alert('日時を選択してください。');
                return;
            }
            
            const dateStr = dateToString(selectedDate);
            const currentUserBookedSlots = getCurrentUserBookedSlots(dateStr);
            
            // 重複チェック
            if (currentUserBookedSlots.includes(selectedTime)) {
                alert('既にその時間は予約済みです。');
                return;
            }
            
            // 予約を追加
            if (!userBookings[currentUser.id][dateStr]) {
                userBookings[currentUser.id][dateStr] = [];
            }
            userBookings[currentUser.id][dateStr].push(selectedTime);
            
            // 確認画面に情報を表示
            document.getElementById('confirmedTeacher').textContent = selectedTeacher;
            document.getElementById('confirmedDateTime').textContent = 
                `${formatDate(selectedDate)} ${selectedTime}`;
            document.getElementById('confirmedStudentId').textContent = currentUser.id;
            
            showScreen('confirmationScreen');
            
            // 選択をリセット
            selectedDate = null;
            selectedTime = null;
            document.getElementById('confirmBooking').style.display = 'none';
            document.getElementById('timeSlotSection').style.display = 'none';
        }

        // 予約一覧表示
        function renderBookingList() {
            const bookingListContainer = document.getElementById('bookingList');
            const userBookingData = userBookings[currentUser.id] || {};
            
            bookingListContainer.innerHTML = '';
            
            const bookings = [];
            Object.keys(userBookingData).forEach(dateStr => {
                userBookingData[dateStr].forEach(time => {
                    bookings.push({ date: dateStr, time: time });
                });
            });
            
            // 日付順にソート
            bookings.sort((a, b) => new Date(a.date) - new Date(b.date));
            
            if (bookings.length === 0) {
                bookingListContainer.innerHTML = '<div class="no-bookings">予約がありません</div>';
                return;
            }
            
            bookings.forEach(booking => {
                const bookingDate = stringToDate(booking.date);
                const bookingItem = document.createElement('div');
                bookingItem.classList.add('booking-item');
                
                bookingItem.innerHTML = `
                    <div class="booking-details">
                        <div class="booking-date">${formatDate(bookingDate)}</div>
                        <div class="booking-time">${booking.time} - ${selectedTeacher}</div>
                    </div>
                    <button class="btn btn-danger btn-small" onclick="deleteBooking('${booking.date}', '${booking.time}')">削除</button>
                `;
                
                bookingListContainer.appendChild(bookingItem);
            });
        }

        // 予約削除
        function deleteBooking(dateStr, time) {
            if (confirm(`${formatDate(stringToDate(dateStr))} ${time}の予約を削除しますか？`)) {
                const userBookingData = userBookings[currentUser.id];
                if (userBookingData[dateStr]) {
                    const index = userBookingData[dateStr].indexOf(time);
                    if (index > -1) {
                        userBookingData[dateStr].splice(index, 1);
                        
                        // 該当日の予約がすべて削除された場合、日付エントリも削除
                        if (userBookingData[dateStr].length === 0) {
                            delete userBookingData[dateStr];
                        }
                        
                        renderBookingList();
                        renderCalendar();
                        
                        // 現在選択中の日付と同じ場合、時間スロットも更新
                        if (selectedDate && dateToString(selectedDate) === dateStr) {
                            renderTimeSlots();
                        }
                    }
                }
            }
        }

        // 月変更
        function changeMonth(direction) {
            currentDate.setMonth(currentDate.getMonth() + direction);
            renderCalendar();
        }

        // ログアウト
        function logout() {
            currentUser = null;
            selectedDate = null;
            selectedTime = null;
            selectedTeacher = '田中先生';
            document.getElementById('studentId').value = '';
            document.getElementById('password').value = '';
            showScreen('loginScreen');
        }

        // 初期化
        document.addEventListener('DOMContentLoaded', function() {
            renderCalendar();
        });
    </script>
</body>
</html>
>>>>>>> e23d73c179664ab082cd0e37a74bbf0e88483c38:htdocs/index.html
