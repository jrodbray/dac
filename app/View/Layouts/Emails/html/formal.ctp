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
<body>
<div id="container">
    <div id="header">
        <h1>Your Certificate</h1>
    </div>
    <div id="content">
        <?php echo $this->fetch('content'); ?>
    </div>
    <div id="footer">
        <p><font color="#a9a9a9">&copy; Disciplined Agile Consortium</font></p>
    </div>
</div>
</body>
</html>
