<?php require __DIR__ . '/comunas-sur.php'; ?>
<datalist id="comunas-sur-list">
  <?php foreach ($comunasSur as $comuna): ?>
    <option value="<?php echo htmlspecialchars($comuna, ENT_QUOTES, 'UTF-8'); ?>"></option>
  <?php endforeach; ?>
</datalist>
