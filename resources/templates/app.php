<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <link rel="stylesheet" href="css/app.css">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Gathers</title>
    </head>
    <body class="<?= $this->e($bodyClasses) ?>">
        <main>
            <?php if ($authenticated): ?>
                <?= $this->fetch('_navigation') ?>
            <?php endif; ?>

            <?= $this->section('content') ?>
        </main>
    </body>
</html>
