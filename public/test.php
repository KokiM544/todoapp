<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>My Todos</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>test</h1>
    <h1><?='http://'. $_SERVER['HTTP_HOST'] . '/work/public/'; ?></h1>
    <h1><?=__DIR__; ?></h1>
    <form action="?action=edit" method="post">
        <input type="text" name="title" placeholder="Type new todo." value="">
        <button type="submit">編集</button>
        <button type="button" onclick="history.back();" class="back">戻る</button>
    </form>
    <script src="js/main.js"></script>
</body>
</html>