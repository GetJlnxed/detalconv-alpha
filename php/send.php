<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';
// Переменные, которые отправляет пользователь
//$name = $_POST['name'];
//$email = $_POST['email'];
//$text = $_POST['text'];

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$productionType = $_POST['prodType'];
$userMessage = $_POST['userMes'];

$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $msg = "ok";
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";                                          
    $mail->SMTPAuth   = true;
    // Настройки вашей почты
    $mail->Host       = 'smtp.mail.ru'; // SMTP сервера GMAIL
    $mail->Username   = 'no-reply@detkonv.ru'; // Логин на почте
    $mail->Password   = '2crxpzps'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('no-reply@detkonv.ru'); // Адрес самой почты и имя отправителя
    // Получатель письма
    $mail->addAddress('info@detkonv.ru');  
//    $mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен
    // Прикрипление файлов к письму
    if (!empty($_FILES['myfile']['name'][0])) {
        for ($ct = 0; $ct < count($_FILES['myfile']['tmp_name']); $ct++) {
            $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['myfile']['name'][$ct]));
            $filename = $_FILES['myfile']['name'][$ct];
            if (move_uploaded_file($_FILES['myfile']['tmp_name'][$ct], $uploadfile)) {
                $mail->addAttachment($uploadfile, $filename);
            } else {
                $msg .= 'Неудалось прикрепить файл ' . $uploadfile;
            }
        }   
    }
    // -----------------------
    // Само письмо
    // -----------------------
    $mail->isHTML(true);

    $mail->Subject = 'Новая заявка';
    $mail->Body    = "<b>Имя:</b> $name <br>
        <b>Телефон:</b> $phone<br>
        <b>Почта:</b> $email<br>
        <b>Выбранный тип продукции:</b> $productionType <br><br>
        <b>Сообщение:</b><br>$userMessage";
    // Проверяем отравленность сообщения
    if ($mail->send()) {
        echo "$msg";
    } else {
        echo "Сообщение не было отправлено. Неверно указаны настройки вашей почты";
    }
} catch (Exception $e) {
    echo "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}
