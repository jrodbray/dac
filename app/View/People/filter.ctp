<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-02
 * Time: 4:45 PM
 */
?>

<h2>Filter People</h2>

    <div class='upper-right-opt'>
        <?php echo $this->Html->link( 'Browse People', array( 'action' => 'index' ) ); ?>
        &nbsp;&nbsp;
        <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
    </div>

<?php
//this is our add form, name the fields same as database column names
echo $this->Form->create(false);
echo $this->Form->input('first_name');
echo $this->Form->input('last_name');
echo $this->Form->input('work_email');
echo $this->Form->input('personal_email');

echo $this->Form->end('Submit');
?>