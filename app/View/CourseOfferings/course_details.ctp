<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-14
 * Time: 11:31 AM
 */
?>

<h2>Course History for <?php echo $person[0]['Person']['first_name'].' '.$person[0]['Person']['last_name']; ?></h2>
<?php
//print_r($person);
?>

<!-- link to add new Course Offering page -->
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'Browse People', array( 'controller' => 'People', 'action' => 'index' )); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>

<table>
    <tr>
        <th>Enrolled</th>
        <th>Start</th>
        <th>End</th>
        <th>Course Code</th>
        <th>Course Description</th>
        <th>Location</th>
        <th>Company</th>
    </tr>

    <!-- Here is where we loop through our $course_offerings array, printing out course info -->

    <?php foreach ($course_offerings as $course_offering): ?>
        <tr>
            <?php $enrollment_date = date('Y-m-d', strtotime($course_offering['Enrollment']['enrollment_date']) ); ?>
            <td><?php echo $enrollment_date; ?></td>
            <td><?php echo $course_offering['CourseOffering']['date']; ?></td>
            <td><?php echo $course_offering['CourseOffering']['end_date']; ?></td>
            <td><?php echo $course_offering['Course']['course_code']; ?></td>
            <td><?php echo $course_offering['Course']['description']; ?></td>
            <td><?php echo $course_offering['CourseOffering']['location']; ?></td>
            <td><?php echo $course_offering['CourseOffering']['company']; ?></td>
        </tr>
    <?php endforeach; ?>
    <?php unset($course_offering); ?>
</table>