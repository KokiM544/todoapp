<?php

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
}

function getPdoInstance() {
    try{
        $pdo = new PDO (
            DSN,
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
    
            ]
        );
        return $pdo;
    
    } catch (PDOException $e){
        echo $e->getMessage();
        exit;
    }
}

function addTodo($pdo) {
    $title = trim(filter_input(INPUT_POST, 'title'));
    if ($title === '') return;
    $stmt = $pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
    $stmt->bindValue('title', $title, PDO::PARAM_STR);
    $stmt->execute();
}

function toggleTodo($pdo) {
    $id = filter_input(INPUT_POST, 'id');
    if(empty($id)) {
        return;
    }else {
        $stmt = $pdo->prepare("UPDATE todos SET is_done = NOT is_done WHERE id = :id");
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

function deleteTodo($pdo) {
    $id = filter_input(INPUT_POST, 'id');
    if(empty($id)) {
        return;
    }else {
        $stmt = $pdo->prepare("DELETE FROM todos WHERE id = :id");
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

function editTodo($pdo) {
    $id = filter_input(INPUT_POST, 'id');
    $title = trim(filter_input(INPUT_POST, 'title'));
    if ($title === '') return;
    if(empty($id)) {
        return;
    }else {
        $stmt = $pdo->prepare("UPDATE todos SET title = :title WHERE id = :id");
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->bindValue('title', $title, PDO::PARAM_STR);
        $stmt->execute();
    }
}

function toeditTodo() {
    $content = filter_input(INPUT_POST, 'content');
    $_SESSION['content'] = $content;
    // exit(SITE_URL . 'edit.php');
    $editurl = SITE_URL . 'edit.php';
    header('Location: ' . $editurl);
    exit(SITE_URL . 'edit.php');
}

function createToken() {
    if(!isset($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
}

function validateToken() {
    if(
        empty($_SESSION['token']) ||
        $_SESSION['token'] !== filter_input(INPUT_POST, 'token')
    ) {
        exit('Invalid post request');
    }
}

function getTodos ($pdo) {
    $stmt = $pdo->query("SELECT * FROM todos ORDER BY id DESC");
    $todos = $stmt->fetchAll();
    return $todos;
}

