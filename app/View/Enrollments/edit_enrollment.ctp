<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-05
 * Time: 11:32 AM
 */
?>
<?php
$course_offering = $this->Session->read('course_offering');
?>
<h2>Edit Enrollment for <?php echo $course_offering[0]['Course']['course_code']; ?> - <?php echo $course_offering[0]['CourseOffering']['date']; ?></h2>
<!-- link to back to Enrollments page -->
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'Back', array('action' => 'edit_enrollments',  $course_offering[0]['CourseOffering']['id']) ); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Enrollments', array( 'controller' => 'Enrollments', 'action' => 'index' ) ); ?>
</div>
<br><br>
<?php
    echo $this->Form->create('Enrollment');
?>
<table>
    <tr>
        <td> <?php  echo $enrollment['Person']['first_name'];
                    echo '&nbsp;';
                    echo $enrollment['Person']['last_name'];
                    echo '&nbsp;';
                    echo $enrollment['Person']['work_email']; ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php
            //this is our edit form, name the fields same as database column names
            echo $this->Form->input('name_on_certificate');
            ?>
        </td>
    </tr>
</table>
<?php
    echo $this->Form->end('Submit');
?>