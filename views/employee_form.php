<?php

$fName = $emp ? $emp->getFirstName() : '';
$lName = $emp ? $emp->getLastName() : '';
$currentGender = $emp ? $emp->getGender() : '';
$currentDeptId = $emp ? $emp->getDepartmentId() : 0;

?>

<h1><?= $headline ?></h1>

<form action="<?= $formAction ?>">
    First Name: <input type="text" name="firstName" value="<?= htmlspecialchars($fName) ?>" required><br>
    Last Name: <input type="text" name="lastName" value="<?= htmlspecialchars($lName) ?>" required><br>
    
    Gender: <select name="gender">
        <option value="<?= Gender::W->value ?>" <?= $currentGender === Gender::W->value ? 'selected' : ''?>>Female</option>
        <option value="<?= Gender::M->value ?>" <?= $currentGender === Gender::M->value ? 'selected' : ''?>>Male</option>
        <option value="<?= Gender::D->value ?>" <?= $currentGender === Gender::D->value ? 'selected' : ''?>>Divers</option>
    </select><br>
    
    Abteilung: <select name="deptId">
        <?php foreach ($allDepts as $d): ?>
        <option value="<?= $d->getId() ?>" <?= $d->getId() === $currentDeptId ? 'selected' : '' ?>>
            <?= htmlspecialchars($d->getName()) ?>
        </option>
        <?php endforeach ?>
    </select><br><br>

    <button type="submit" class="btn">Save</button>
</form>