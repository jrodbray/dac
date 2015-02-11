<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-09
 * Time: 6:56 PM
 */
?>

<h2>Edit Instructional Organization</h2>

<!-- link to list entities page -->
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'List Instructional Organizations', array( 'action' => 'index' ) ); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Back', '/pages/admin_menu'); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>

<?php
//this is our add form, name the fields same as database column names
echo $this->Form->create('Entity');
echo $this->Form->input('name');
echo $this->Form->input('code');
echo $this->Form->input('phone');
echo $this->Form->input('address1');
echo $this->Form->input('address2');
echo $this->Form->input('city');
echo $this->Form->input('prov_state', array('label' => 'Province or State'));
echo $this->Form->input('country');
echo $this->Form->input('postal_code');

echo $this->Form->end('Submit');
?>
<br>
