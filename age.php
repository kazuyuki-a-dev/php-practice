<?php

function validateBirthday(string $birthday): string
{
    if (trim($birthday) === '') {
        return '日付を入力してください。';
    }
    // $birthDate, $todayをここと下のif文で二重に計算している。無駄なので、リファクタリングが必要ではあるが、今回は基礎中の基礎のPHP学習中につき現状のままにとどめる。
    $birthDate = new DateTime($birthday);
    $today = new DateTime();

    if ($birthDate > $today) {
        return '未来の日付は入力できません';
    }
    return '';
}

$age = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $birthday = $_POST['birthday'] ?? '';

    $error = validateBirthday($birthday);

    if ($error === '') {
        $birthDate = new DateTime($birthday);
        $today = new DateTime();
        $diff = $today->diff($birthDate);
        $age = $diff->y;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>年齢計算器</title>
</head>

<body>
    <h1>年齢計算機</h1>

    <?php if ($error !== ''): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="age.php" method="post">
        <label for="birthday">誕生日</label>
        <input type="date" name="birthday" id="birthday">

        <button type="submit">計算する</button>
    </form>

    <?php
    if ($age !== null): ?>
        <p>あなたは<?php echo $age; ?>歳です。</p>
    <?php endif; ?>
</body>

</html>