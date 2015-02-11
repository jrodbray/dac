<h2>Student Search Results</h2>
<?php
$course_offering = $this->Session->read('course_offering');
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
<!-- link to back to Enrollments page -->
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'Back to Enrollments', array( 'controller' => 'Enrollments', 'action' => 'index' ) ); ?>
</div>

<?php
$people = $this->Session->read('people');
if($people){
    echo $this->Form->create('Person');
    echo $this->Form->input('Date.enrollment_date', array('type' => 'text', 'id' => 'datepicker', 'required' => true, 'div' => array('class' => 'required')));
//creating our table
    echo "<table>";

    echo "<tr>";

    echo "<th>ID</th>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>Work Email</th>";
    echo "<th>Personal Email</th>";
    echo "</tr>";

    // loop through the user's records
    $i = 0;
    foreach( $people as $person ){
        echo "<tr>";
        echo "<td>{$person['Person']['id']}</td>";
        echo "<td>{$person['Person']['first_name']}</td>";
        echo "<td>{$person['Person']['last_name']}</td>";
        echo "<td>{$person['Person']['work_email']}</td>";
        echo "<td>{$person['Person']['personal_email']}</td>";

        echo "<td>".$this->Form->hidden('Enrollment.'.$i.'.person_id', array('value' => $person['Person']['id']))." ". $this->Form->input('Person.'.$i.'.name_on_certificate')."</td>";
        echo "</td>";
        echo "</tr>";
        $i++;
    }

    echo "</table>";
    echo $this->Form->end('Submit');

}

// tell the user there's no records found
else{
    echo "No people found.";
}
?>
<br>
<?php
//echo print_r($people);
?>
<br>
