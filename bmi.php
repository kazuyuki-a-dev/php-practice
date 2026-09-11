<?php

    function validateHeight(string $height): string
    {
        if (trim($height) === '') {
            return '身長を入力してください。';
        } elseif (!is_numeric($height) || $height <= 0) {
            return '正しい身長を入力してください。';
        }
        return '';
    }

    function validateWeight(string $weight): string
    {
        if (trim($weight) === '') {
            return '体重を入力してください。';
        } elseif (!is_numeric($weight) || $weight <= 0) {
            return '正しい体重を入力してください。';
        }
        return '';
    }

$bmi = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $height = $_POST['height'] ?? '';
    $weight = $_POST['weight'] ?? '';

    $error = validateHeight($height);
    if ($error === '') {
        $error = validateWeight($weight);
    }

    if ($error === '') {
        $heightInMeters = $height / 100;
        $bmi = $weight / ($heightInMeters * $heightInMeters);
        $bmi = round($bmi, 1);
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>BMI計算機</title>
</head>

<body>
    <h1>BMI計算機</h1>

    <?php if ($error !== ''): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="bmi.php" method="post">
        <label for="height">身長(cm)</label>
        <input type="text" name="height" id="height">

        <label for="weight">体重(kg)</label>
        <input type="text" name="weight" id="weight">

        <button type="submit">計算する</button>
    </form>

    <?php
    if ($bmi !== null): ?>
        <p>あなたのBMIは<?php echo $bmi; ?>です。</p>
    <?php endif; ?>
</body>

</html>