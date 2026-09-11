<?php

function validateHand(string $hand): string
{
    if (trim($hand) === '') {
        return '手を選んでください。';
    } elseif (!in_array($hand, ['グー', 'チョキ', 'パー'])) {
        return '正しい手を選んでください。';
    }
    return '';
}
$hands = ['グー', 'チョキ', 'パー'];

$result = null;
$userHand = null;
$computerHand = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userHand = $_POST['hand'] ?? '';

    $error = validateHand($userHand);

    if ($error === '') {
        $computerIndex = array_rand($hands);
        $computerHand = $hands[$computerIndex];

        if ($userHand === $computerHand) {
            $result = 'あいこ';
        } elseif (
            ($userHand === 'グー' && $computerHand === 'チョキ') ||
            ($userHand === 'チョキ' && $computerHand === 'パー') ||
            ($userHand === 'パー' && $computerHand === 'グー')
        ) {
            $result = 'あなたの勝ち';
        } else {
            $result = 'あなたの負け';
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
    <title>じゃんけんゲーム</title>
</head>

<body>
    <h1>じゃんけんゲーム</h1>

    <?php if ($error !== ''): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="janken.php" method="post">
        <label for="hand">あなたの手</label>
        <select name="hand" id="hand">
            <option value="グー">グー</option>
            <option value="チョキ">チョキ</option>
            <option value="パー">パー</option>
        </select>

        <button type="submit">勝負する</button>
    </form>

    <?php if ($result !== null): ?>
        <p>あなた: <?php echo htmlspecialchars($userHand); ?> / コンピュータ: <?php echo htmlspecialchars($computerHand); ?></p>
        <p><?php echo htmlspecialchars($result); ?>です。</p>
    <?php endif; ?>
</body>

</html>