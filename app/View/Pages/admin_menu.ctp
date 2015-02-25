<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-30
 * Time: 9:35 AM
 */
?>
<h2>Admin Menu</h2>
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>
<br><br>
<?php
echo $this->Html->link( 'Courses',     array(
    'controller' => 'courses',
    'action' => 'index',
    'full_base' => true
));
?>
<br><br>
<?php
echo $this->Html->link( 'Instructors',     array(
    'controller' => 'instructors',
    'action' => 'index',
    'full_base' => true
));
?>
    <br><br>
<?php
echo $this->Html->link( 'Instructional Organizations',     array(
    'controller' => 'entities',
    'action' => 'index',
    'full_base' => true
));
?>
<br><br>
<?php
echo $this->Html->link( 'FAQ Entries',     array(
    'controller' => 'faqs',
    'action' => 'index',
    'full_base' => true
));
?>
