<h2>Edit Person</h2>

<!-- link to list users page -->
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'List People', array( 'action' => 'index' ) ); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Back', '/pages/people_menu'); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>

<?php
//this is our edit form, name the fields same as database column names
echo $this->Form->create('Person');
echo $this->Form->input('work_email');
echo $this->Form->input('designation');
echo $this->Form->input('first_name');
echo $this->Form->input('middle_name');
echo $this->Form->input('last_name');
echo $this->Form->input('admin_notes');
echo $this->Form->input('work_phone');
echo $this->Form->input('home_phone');
echo $this->Form->input('mobile_phone');
echo $this->Form->input('personal_email');

echo $this->Form->end('Submit');
?>