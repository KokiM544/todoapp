<?php

require_once(__DIR__. '/../app/config.php');
createToken();
$pdo = getPdoInstance();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateToken();
    $action = filter_input(INPUT_GET, 'action');
    switch($action) {
        case 'add':
            $id = addTodo($pdo);
            header('Content-Type: application/json');
            echo json_encode(['id' => $id]);
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
    // header('Location: ' . SITE_URL);
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
    <header>
        <div>
            <img src="img/header-icon-256.png" width="128" height="80" class="header-img">
            <h1>Todo App</h1>
        </div>
        <div class="links">
            <a href="">テスト</a>
            <a href="">テスト</a>
            <a href="">テスト</a>
        </div>
    </header>
    <main class="field">
        <main class="todos" data-token="<?=h($_SESSION['token']); ?>">
            <!-- <h1>My Todos</h1> -->
        
            <form class="add">
                <input type="text" name="title" placeholder="Type new todo.">
                <input type="hidden" name="token" value="<?=h($_SESSION['token']); ?>">
            </form>
        
            <ul>
                <?php foreach($todos as $todo): ?>
                <li data-id="<?=h($todo->id); ?>">
                    <label>
                        <input 
                        type="checkbox"
                        class="todo-check"
                        <?= $todo->is_done ? 'checked': ""; ?>>
                        <div class="DummyInput"></div>
                    </label>
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
                        
                        <!-- <form action="?action=delete" method="post" class="delete-form"> -->
                            <!-- <span class="delete">X</span> -->
                            <div class="delete"></div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </main>
    </main>

    <script src="js/main.js"></script>
</body>
</html>