<?php
?>

<h1><?= $headline ?></h1>
<form action="<?= $formAction ?>" method="post">
    Name: <input type="text" name="dept_name" value="<?= htmlspecialchars($deptName) ?>" required><br><br>
    <button type="submit" class="btn">Save</button>
</form>
