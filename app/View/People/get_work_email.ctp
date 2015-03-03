<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-24
 * Time: 2:18 PM
 */
?>
<?php
    $course_offering = $this->Session->read('course_offering');
?>
<h2>Trying Autocomplete by Work Email</h2>
<h3>Work Email Autocomplete Form</h3>
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
  //form with autocomplete class field
  echo $this->Form->create(false);
  echo $this->Form->input('workEmail', array('class' => 'ui-widget', 'id' => 'autocomplete'));
  echo $this->Form->end();

  echo $this->Form->create('Person', array('type' => 'get', 'action' => 'fillForm', 'id' => 'workEmailForm'));
  echo $this->Form->input('workEmail', array('type' => 'hidden', 'id' => 'email_key'));
  echo $this->Form->submit('Next');
?>