<h2>Edit Course Offering</h2>

<!-- link to list users page -->
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'List Course Offerings', array( 'action' => 'index' ) ); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>

<?php
//this is our edit form, name the fields same as database column names
echo $this->Form->create('CourseOffering');
echo $this->Form->input('date', array('type' => 'text', 'id' => 'datepicker'));
echo $this->Form->input('end_date', array('type' => 'text', 'id' => 'datepicker2'));
?>


<?php
$options = array();
foreach ($all_entities as $entity):
    $options[] = array('name' => $entity['Entity']['name'],
        'value' => $entity['Entity']['id']);
endforeach;
echo $this->Form->select('entity_id',$options, array('empty' => 'Select Instructional Organization'));

echo "&nbsp;";

$options = array();
foreach ($all_instructors as $instructor):
    $options[] = array('name' => $instructor['Person']['last_name'].', '.$instructor['Person']['first_name'],
        'value' => $instructor['Instructor']['id']);
endforeach;
echo $this->Form->select('instructor_id',$options, array('empty' => 'Select Instructor'));

echo "&nbsp;";

$options = array();
foreach ($all_courses as $course):
    $options[] = array('name' => $course['Course']['course_code'].', '.$course['Course']['description'],
        'value' => $course['Course']['id']);
endforeach;
echo $this->Form->select('course_id',$options, array('empty' => 'Select Course'));
echo $this->Form->input('location');
echo $this->Form->input('company');
echo $this->Form->input('admin_notes');
echo $this->Form->end('Submit');
?>
<br>
<?php
//echo print_r($all_instructors);
echo '<br><br>';
//echo print_r($all_courses);
?>
