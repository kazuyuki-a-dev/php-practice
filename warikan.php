<?php

function validateTotal(string $total): string
{
    if (trim($total) === '') {
        return '合計金額を入力してください。';
    } elseif (!is_numeric($total) || $total <= 0) {
        return '正しい合計金額を入力してください。';
    }
    return '';
}

function validatePeople(string $people): string
{
    if (trim($people) === '') {
        return '人数を入力してください。';
    } elseif (!is_numeric($people) || $people <= 0) {
        return '正しい人数を入力してください。';
    }
    return '';
}

$pricePerPerson = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total = $_POST['total'] ?? '';
    $people = $_POST['people'] ?? '';

    $error = validateTotal($total);
    if ($error === '') {
        $error = validatePeople($people);
    }

    if ($error === '') {
        $pricePerPerson = $total / $people;
        $pricePerPerson = ceil($pricePerPerson);
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>割り勘計算機</title>
</head>

<body>
    <h1>割り勘計算機</h1>

    <?php if ($error !== ''): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="warikan.php" method="post">
        <label for="total">合計金額</label>
        <input type="text" name="total" id="total">

        <label for="people">人数</label>
        <input type="text" name="people" id="people">

        <button type="submit">計算する</button>
    </form>

    <?php
    if ($pricePerPerson !== null): ?>
        <p>一人当たり<?php echo $pricePerPerson; ?>円です。</p>
    <?php endif; ?>
</body>

</html>