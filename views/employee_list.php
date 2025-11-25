<?php
?>
<h1>Employees</h1>
<?php if ($tableHtml): ?>
    <?= $tableHtml ?>
<?php else: ?>
    <p>Keine Mitarbeiter gefunden</p>
<?php endif; ?>

<br><a href="index.php?action=new_employee" class="btn">+ Neuer Mitarbeiter</a>
