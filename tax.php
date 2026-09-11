<?php

function validateAmount(string $amount): string
{
    if (trim($amount) === '') {
        return '金額を入力してください。';
    } elseif (!is_numeric($amount) || $amount <= 0) {
        return '正しい金額を入力してください。';
    }
    return '';
}

$priceWithTax = null;
$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'] ?? '';

    $error = validateAmount($amount);

    if ($error === '') {
        $priceWithTax = $amount * 1.1;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>消費税計算機</title>
</head>

<body>
    <h1>消費税計算機</h1>

    <?php if ($error !== ''): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="tax.php" method="post">
        <label for="amount">金額(円)</label>
        <input type="text" name="amount" id="amount">

        <button type="submit">計算する(税込み)</button>
    </form>

    <?php
    if ($priceWithTax !== null): ?>
        <p>税込み価格は<?php echo $priceWithTax; ?>円です。</p>
    <?php endif; ?>
</body>

</html>