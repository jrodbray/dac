<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-30
 * Time: 9:25 AM
 */
?>
<h2>Enrollments Menu</h2>
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>
<br><br>
<?php
echo $this->Html->link( 'Enroll Students',     array(
    'controller' => 'enrollments',
    'action' => 'index',
    'full_base' => true
));
?>
<br><br>
<?php
echo $this->Html->link( '(TRIAL) Report all Course Offerings',     array(
    'controller' => 'enrollments',
    'action' => 'enrollments_report',
    'full_base' => true
));
?>
<?php

?>
