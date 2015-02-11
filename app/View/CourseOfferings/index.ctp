<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-14
 * Time: 11:31 AM
 */
?>

<?php
$active_filter = $this->Session->read('active_filter');
if($active_filter) {
    echo "<h2>Filter Course Offerings</h2>";
    echo "<b>".$this->FilterDisplay->display($active_filter)."</b><br><br>";
}else{
    echo "<h2>Browse Course Offerings</h2>";
}
?>

<!-- link to add new Course Offering page -->
<div class='upper-right-opt'>
    <?php
    if($active_filter) {
        echo $this->Html->link('Clear Filter', array('action' => 'clear_filter'));
    } else{
        echo $this->Html->link('Filter Course Offerings', array('action' => 'filter'));
    }
    ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Add New Course Offering', array( 'action' => 'add' ) ); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>

<?php
$paginator = $this->Paginator;

if($course_offerings){
?>
<table>
    <tr>
        <th>ID</th>
        <th>Start</th>
        <th>End</th>
        <th>Course<br>Code</th>
        <th>Course Description</th>
        <th>Instructor</th>
        <th>Location</th>
        <th>Company</th>
        <th>Action</th>
    </tr>

    <!-- Here is where we loop through our $course_offerings array, printing out course info -->

    <?php foreach ($course_offerings as $course_offering): ?>
    <tr>
        <td><?php echo $course_offering['CourseOffering']['id']; ?></td>
        <td><?php echo $course_offering['CourseOffering']['date']; ?></td>
        <td><?php echo $course_offering['CourseOffering']['end_date']; ?></td>
        <td><?php echo $course_offering['Course']['course_code']; ?></td>
        <td><?php echo $course_offering['Course']['description']; ?></td>
        <td><?php echo $course_offering['Entity']['code'].' - '.$course_offering['Person']['last_name']; ?></td>
        <td><?php echo $course_offering['CourseOffering']['location']; ?></td>
        <td><?php echo $course_offering['CourseOffering']['company']; ?></td>
        <?php echo "<td class='actions'>";
            if($course_offering['CourseOffering']['cancelled']){
                echo "CANCELLED";
            }else {
                echo $this->Html->link( 'Edit', array('action' => 'edit', $course_offering['CourseOffering']['id']) );

                echo $this->Form->postLink('Cancel', array(
                    'action' => 'cancel',
                    $course_offering['CourseOffering']['id']), array(
                    'confirm' => 'Are you sure you want to cancel that Course Offering?'));

                 echo $this->Form->postLink( 'Class List', array(
                    'controller' => 'Enrollments', 'action' => 'class_list', $course_offering['CourseOffering']['id']) );
            }
        echo "</td>";
        ?>
    </tr>
<?php endforeach; ?>
<?php unset($course_offering); ?>
</table>
<?php
// pagination section
echo "<div class='paging'>";

// the 'first' page button
echo $paginator->first("First");

// 'prev' page button,
// we can check using the paginator hasPrev() method if there's a previous page
// save with the 'next' page button
if($paginator->hasPrev()){
    echo $paginator->prev("Prev");
}

// the 'number' page buttons
echo $paginator->numbers(array('modulus' => 2));

// for the 'next' button
if($paginator->hasNext()){
    echo $paginator->next("Next");
}

// the 'last' page button
echo $paginator->last("Last");

echo "</div>";

}

// tell the user there's no records found
else{
    echo "No Course Offerings found using filter.";
}
?>