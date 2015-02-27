<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-25
 * Time: 1:45 PM
 */

?>
    <h2>Enrolling / Editing Person</h2>
<?php
$course_offering = $this->Session->read('course_offering');
//print_r($course_offering);
?>
    <table>
        <tr>
            <td><b>Enrolling for:</b></td>
            <td><b><?php echo $course_offering[0]['Course']['course_code']; ?></b></td>
            <td><b><?php echo $course_offering[0]['Course']['description']; ?></b></td>
            <td><b><?php echo $course_offering[0]['CourseOffering']['date']; ?></b></td>
            <td><b><?php echo $course_offering[0]['CourseOffering']['location']; ?></b></td>
        </tr>
    </table>

    <!-- link to list users page -->
    <div class='upper-right-opt'>
        <?php echo $this->Html->link( 'Back to Enrollments', array( 'controller' => 'Enrollments', 'action' => 'index' ) ); ?>
    </div>

<?php
//this is our add form, name the fields same as database column names
echo $this->Form->create('Person');
echo $this->Form->input('id', array('type' => 'hidden'));
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

echo $this->Form->input('enrollment_date', array('type' => 'text', 'id' => 'datepicker', 'required' => true, 'div' => array('class' => 'required')));
echo $this->Form->input('name_on_certificate', array('required' => true, 'div' => array('class' => 'required')));

echo $this->Form->end('Submit');
?>