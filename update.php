<link rel="stylesheet" href="style.css">


<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function text($value) {
    return htmlentities($value, ENT_COMPAT | ENT_HTML401 | ENT_QUOTES, 'utf-8');
}

if (array_key_exists('update', $_GET) &&
    is_string($_GET['update']) &&
    $_GET['update'] !== ''
) {
    $id = $_GET['update'];

    include 'DB.php';
    $db = new DB();
    $entry = $db->get($id);
}
else {
    $entry = [];
    $id = '';
}

?>
<form action="request.php" onsubmit="postSubmit.bind(this)(event, updateElement)">
    <input type="hidden" name="id" value="<?=$id; ?>">
    <label for="comment-name">Name</label>
    <input type="text" name="name" id="comment-name" value="<?= text(@$entry['name']); ?>">

    <label for="comment-message">Comment</label>
    <textarea name="comment" id="comment-message" cols="30" rows="10"><?= text(@$entry['comment']); ?></textarea>
    <button type="submit">add comment</button>
</form>

<script src="script.js"></script>
<script>
    console.log("Hello world");
</script>