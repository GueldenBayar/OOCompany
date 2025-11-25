<?php
?>
<h1>Departments</h1>

<?php if ($tableHtml): ?>
    <?= $tableHtml ?>
<?php else: ?>
    <p>Keine Abteilungen gefunden.</p>
<?php endif; ?>

<br><a href="index.php?action=new_dept" class="btn">+new Department</a>

