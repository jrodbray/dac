<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-19
 * Time: 7:57 PM
 */
?>
<h2>Add new Instructors</h2>
<!-- link to add new users page -->
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'List Instructors', array( 'action' => 'index' ) ); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Back', '/pages/admin_menu'); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>


<table>
    <tr>
        <th>Id</th>
        <th>First</th>
        <th>Last</th>
        <th>Work Email</th>
        <th>Personal Email</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <!-- Here is where we loop through our $people array, printing out people info -->
    <?php
    $people = $this->Session->read("people");
    //print_r($people);
    ?>
    <?php foreach ($people as $person): ?>
        <tr>
            <td><?php echo $person['Person']['id']; ?></td>
            <td><?php echo $person['Person']['first_name']; ?></td>
            <td><?php echo $person['Person']['last_name']; ?></td>
            <td><?php echo $person['Person']['work_email']; ?></td>
            <td><?php echo $person['Person']['personal_email']; ?></td>
            <td>
                <?php
                $instructor = false;
                if($person['Instructor']['id']){
                    // already an Instructor BUT might be inactive
                    $instructor = true;
                    echo 'Already Instructor';
                }
                $inactive = false;
                if($person['Instructor']['inactive']){
                    $inactive = true;
                    if($instructor) echo ', ';
                    echo 'INACTIVE';
                }
                ?>
            </td>
            <td class='actions'>
                <?php
                if(!$instructor && !$inactive) {
                    echo $this->Form->postLink( 'Set as Instructor', array(
                        'action' => 'add',
                        $person['Person']['id']), array(
                        'confirm'=>'Are you sure you want to set that Person as an Instructor?' ) );
                } ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php unset($person); ?>
</table>