<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-19
 * Time: 7:57 PM
 */
?>
    <h2>Search for People to Set as Instructors</h2>
    <!-- link to add new users page -->
    <div class='upper-right-opt'>
        <?php echo $this->Html->link( 'List Instructors', array( 'action' => 'index' ) ); ?>
        &nbsp;&nbsp;
        <?php echo $this->Html->link( 'Back', '/pages/admin_menu'); ?>
        &nbsp;&nbsp;
        <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
    </div>


<?php
//this is our edit form, name the fields same as database column names
echo $this->Form->create('Instructor', array('action' => 'search'));
echo $this->Form->input('last_name');
echo $this->Form->input('work_email');

echo $this->Form->end('Search');
?>