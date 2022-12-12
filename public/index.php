<?php

require_once(__DIR__. '/../app/config.php');

createToken();

$pdo = getPdoInstance();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateToken();
    $action = filter_input(INPUT_GET, 'action');
    switch($action) {
        case 'add':
            addTodo($pdo);
            break;
        case 'toggle':
            toggleTodo($pdo);
            break;
        case 'delete':
            deleteTodo($pdo);
            break;
        case 'edit':
            editTodo($pdo);
            break;
        case 'toedit':
            toeditTodo();
            break;
        default:
            exit;
    }
    header('Location: ' . SITE_URL);
    exit;
}

$todos = getTodos($pdo);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>My Todos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main>
        <h1>My Todos</h1>
    
        <form action="?action=add" method="post">
            <input type="text" name="title" placeholder="Type new todo.">
            <input type="hidden" name="token" value="<?=h($_SESSION['token']); ?>">
        </form>
    
        <ul>
            <?php foreach($todos as $todo): ?>
            <li>
                <form action="?action=toggle" method="post">
                    <input type="checkbox" <?= $todo->is_done ? 'checked': ""; ?>>
                    <input type="hidden" name="id" value="<?=h($todo->id); ?>">
                    <input type="hidden" name="token" value="<?=h($_SESSION['token']); ?>">
                </form>
                <!-- <form action="?action=edit" method="post">
                    <span class ="title <?= $todo->is_done ? "done" : ""; ?>">
                        <?= h($todo->title); ?>
                    </span>
                    <input type="hidden" name="id" value="<?=h($todo->id); ?>">
                    <input type="hidden" name="token" value="<?=h($_SESSION['token']); ?>">
                </form> -->
                <span class ="title <?= $todo->is_done ? "done" : ""; ?>">
                        <?= h($todo->title); ?>
                </span>
                <div class="test">
                    <!-- <form action="?action=toedit" method="post"> -->
                    <form action="edit.php/?action=toedit" method="post">
                        <div class="edit-button-img"></div>
                        <input type="hidden" name="content" value="<?=h($todo->title); ?>">
                        <input type="hidden" name="id" value="<?=h($todo->id); ?>">
                        <input type="hidden" name="token" value="<?=h($_SESSION['token']); ?>">
                    </form>
                    <form action="?action=delete" method="post" class="delete-form">
                        <!-- <span class="delete">X</span> -->
                        <div class="delete"></div>
                        <input type="hidden" name="id" value="<?=h($todo->id); ?>">
                        <input type="hidden" name="token" value="<?=h($_SESSION['token']); ?>">
                    </form>
                </div>
                <!-- <div class="spacer"></div>
                <span class="post-date">投稿日：2022/11/11</span>
                <div class="spacer"></div>
                <span class="update-date">更新日：2022/12/11</span> -->
    
            </li>
            <?php endforeach; ?>
        </ul>
    </main>
    <div class="circle">

    </div>

    <script src="js/main.js"></script>
</body>
</html>