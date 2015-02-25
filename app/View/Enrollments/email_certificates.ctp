<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-24
 * Time: 10:01 AM
 */
?>
    <h2>Emailed Certificates for <?php echo $course_offering[0]['Course']['course_code']; ?> - <?php echo $course_offering[0]['CourseOffering']['date']; ?></h2>

    <!-- link to move back -->
<div class='upper-right-opt'>
<?php echo $this->Html->link( 'Browse Course Offerings', array( 'action' => 'index' ) ); ?>
&nbsp;&nbsp;
<?php echo $this->Html->link( 'Enrollments Menu', '/pages/enrollments_menu'); ?>
&nbsp;&nbsp;
<?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>
<?php
if($data_array){
?>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
        </tr>
<?php
    $count=0;
    foreach ($data_array as $data) {
        $count++;
        echo '<tr><td>'.$data['Name'],'</td><td>'.$data['email'].'</td></tr>';
    }
    echo '</table>';
    echo '<br>&nbsp;Count '.$count;
}else{
    echo "No Students found.";
}
?>