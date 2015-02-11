<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-31
 * Time: 10:23 PM
 */
?>
<?php
$course_offering = $this->Session->read('course_offering');
?>
<h2>Class List for <?php echo $course_offering[0]['Course']['course_code']; ?> - <?php echo $course_offering[0]['CourseOffering']['date']; ?></h2>
<!-- link to back to Enrollments page -->
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'Enrollments', array( 'controller' => 'Enrollments', 'action' => 'index' ) ); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>
<br><br>
<?php
if($people) {

//creating our table
    echo "<table>";

    // our table header, we can sort the data user the paginator sort() method!
    echo "<tr>";

    // in the sort method, the first parameter is the same as the column name in our table
    // the second parameter is the header label we want to display in the view
    echo "<th>ID</th>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>Work Email</th>";
    echo "<th>Personal Email</th>";
    echo "<th>Name on Certificate</th>";
    echo "</tr>";

    // loop through the user's records
    foreach ($people as $person) {
        echo "<tr>";
        echo "<td>{$person['Person']['id']}</td>";
        echo "<td>{$person['Person']['first_name']}</td>";
        echo "<td>{$person['Person']['last_name']}</td>";
        echo "<td>{$person['Person']['work_email']}</td>";
        echo "<td>{$person['Person']['personal_email']}</td>";
        echo "<td>{$person['Enrollment']['name_on_certificate']}</td>";
        echo "</tr>";
    }

    echo "</table>";
}else{
    echo "No people found.";
}
?>