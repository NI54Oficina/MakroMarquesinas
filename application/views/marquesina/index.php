<h2><?php echo $title; ?></h2>

<?php foreach ($marquesinas as $marquesina): ?>

        <h3><?php echo $marquesina['nombre']; ?></h3>
        <div class="main">
                <?php echo $marquesina['descripcion']; ?>
        </div>
        <p><a href="<?php echo site_url('news/'.$marquesina['id']); ?>">Ver marquesina</a></p>

<?php endforeach; ?>