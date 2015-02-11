<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-04
 * Time: 10:27 AM
 */
?>

<h2>Filter Course Offerings</h2>

<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'Browse Course Offerings', array( 'action' => 'index' ) ); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>

<?php
//this is our edit form, name the fields same as database column names
echo $this->Form->create(false);
echo $this->Form->input('date', array('label' => 'After', 'type' => 'text', 'id' => 'datepicker'));

$options = array();
foreach ($all_organizations as $organization):
    $options[] = array('name' => $organization['Entity']['name'],
        'value' => $organization['Entity']['id']);
endforeach;
echo $this->Form->select('entity_id',$options, array('empty' => 'Select Instructing Organization'));
echo '&nbsp;&nbsp;';
$options = array();
foreach ($all_instructors as $instructor):
    $options[] = array('name' => $instructor['Person']['last_name'].', '.$instructor['Person']['first_name'],
        'value' => $instructor['Instructor']['id']);
endforeach;
echo $this->Form->select('instructor_id',$options, array('empty' => 'Select Instructor'));
echo '&nbsp;&nbsp;';
$options = array();
foreach ($all_courses as $course):
    $options[] = array('name' => $course['Course']['course_code'].', '.$course['Course']['description'],
        'value' => $course['Course']['id']);
endforeach;
echo $this->Form->select('course_id',$options, array('empty' => 'Select Course'));

echo $this->Form->end('Submit');
?>
<br>