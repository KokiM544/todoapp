<?php

require_once(__DIR__. '/../app/config.php');

createToken();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateToken();
    $action = filter_input(INPUT_GET, 'action');
    switch($action) {
        case "toedit":
            $content = filter_input(INPUT_POST, 'content');
            $id = filter_input(INPUT_POST, 'id');
            break;
        case "edit":
            editTodo(getPdoInstance());
            header('Location: ' . SITE_URL);
            exit;
            break;

    }
} else {
    header('Location: ' . SITE_URL);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>My Todos</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <main>
        <form action="?action=edit" method="post">
            <input type="text" name="title" placeholder="Type new todo." value="<?=h($content); ?>">
            <div class="editbtn">
                <button type="submit">編集</button>
                <button type="button" onclick="history.back();" class="back">戻る</button>
            </div>
            <input type="hidden" name="id" value="<?=h($id); ?>">
            <input type="hidden" name="token" value="<?=h($_SESSION['token']); ?>">
        </form>
    </main>
</body>
</html>