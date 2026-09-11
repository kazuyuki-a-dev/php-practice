<?php

function validateValue(string $value): string
{

    if (trim($value) === '') {
        return '数値を入力してください。';
    } elseif (!is_numeric($value)) {
        return '正しい数値を入力してください。';
    }
    return '';
}

$result = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['value'] ?? '';
    $direction = $_POST['direction'] ?? '';
    $error = validateValue($value);
    if ($error === '') {
        switch ($direction) {
            case 'km_to_mile':
                $result = round($value * 0.621371, 2) . ' マイル';
                break;
            case 'mile_to_km':
                $result = round($value * 1.60934, 2) . ' km';
                break;
            default:
                $error = '変換方向を選択してください。';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>単位変換ツール</title>
</head>

<body>
    <h1>単位変換ツール(距離)</h1>

    <?php if ($error !== ''): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="convert.php" method="post">
        <label for="value">数値</label>
        <input type="text" name="value" id="value">

        <label for="direction">変換方向</label>
        <select name="direction" id="direction">
            <option value="km_to_mile">km → マイル</option>
            <option value="mile_to_km">マイル → km</option>
        </select>

        <button type="submit">変換する</button>
    </form>

    <?php if ($result !== null): ?>
        <p>変換結果: <?php echo htmlspecialchars($result); ?></p>
    <?php endif; ?>
</body>

</html>