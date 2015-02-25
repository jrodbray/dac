<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-29
 * Time: 7:42 PM
 */
?>
    <h2>People Menu</h2>
    <div class='upper-right-opt'>
        <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
    </div>
    <br><br>
<?php
echo $this->Html->link( 'Administer',     array(
    'controller' => 'people',
    'action' => 'index',
    'full_base' => true
));
?>