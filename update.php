<link rel="stylesheet" href="style.css">


<?php
    if (array_key_exists('update', $_GET) &&
        !is_array($_GET['update']) &&
        $_GET['update'] !== ''
    ) {
        $id = $_GET['update'];
    }
    else {
        $id = '';
    }
?>
<form action="request.php" method="post">
    <input type="hidden" name="id" value="<?=$id; ?>">
    <label for="comment-name">Name</label>
    <input type="text" name="name" id="comment-name">

    <label for="comment-message">Comment</label>
    <textarea name="comment" id="comment-message" cols="30" rows="10"></textarea>
    <button type="submit">add comment</button>
</form>