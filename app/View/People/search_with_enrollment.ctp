<h2>Search Existing Students to Enroll</h2>
<!-- link to back to Enrollments page -->
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'Back to Enrollments', array( 'controller' => 'Enrollments', 'action' => 'index' ) ); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Enrollments Menu', '/pages/enrollments_menu'); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>


<?php
//this is our edit form, name the fields same as database column names
echo $this->Form->create('Person', array('action' => 'search_with_enrollment'));
echo $this->Form->input('last_name');
//echo $this->Form->input('work_email');
//echo $this->Form->input('personal_email');

echo $this->Form->end('Submit');
?>