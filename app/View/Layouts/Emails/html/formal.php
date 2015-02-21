<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-21
 * Time: 1:50 PM
 */
?>
<!DOCTYPE html>
<html>

<head>
    <?php echo $this->Html->charset(); ?>

    <?php
    echo $this->Html->meta('icon');

    echo $this->Html->css('cake.generic');
    ?>
</head>
<body>
<div id="container">
    <div id="header" class="no-print">
        <h1>Your Certificate</h1>
    </div>
    <div id="content">
        <?php echo $this->fetch('content'); ?>
    </div>
    <div id="footer" class="no-print">
        <p>
            <?php echo $cakeVersion; ?>
        </p>
    </div>
</div>
</body>
</html>
