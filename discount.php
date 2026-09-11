<?php
function validatePrice(string $price): string
{
    if (trim($price) === '') {
        return '定価を入力してください。';
    } elseif (!is_numeric($price) || $price <= 0) {
        return '正しい定価を入力してください。';
    }
    return '';
}

function validateDiscountRate(string $rate): string
{
    if (trim($rate) === '') {
        return '割引率を入力してください。';
    } elseif (!is_numeric($rate) || $rate < 0 || $rate > 100) {
        return '割引率は0〜100の範囲で入力してください。';
    }
    return '';
}

$discountedPrice = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $price = $_POST['price'] ?? '';
    $rate = $_POST['rate'] ?? '';

    $error = validatePrice($price);
    if ($error === '') {
        $error = validateDiscountRate($rate);
    }

    if ($error === '') {
        $discountedPrice = $price * (1 - $rate / 100);
        $discountedPrice = floor($discountedPrice);
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>割引計算機</title>
</head>

<body>
    <h1>割引計算機</h1>

    <?php if ($error !== ''): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="discount.php" method="post">
        <label for="price">定価(円)</label>
        <input type="text" name="price" id="price">

        <label for="rate">割引率(%)</label>
        <input type="text" name="rate" id="rate">

        <button type="submit">計算する</button>
    </form>

    <?php if ($discountedPrice !== null): ?>
        <p>割引後の価格は<?php echo $discountedPrice; ?>円です。</p>
    <?php endif; ?>
</body>

</html>