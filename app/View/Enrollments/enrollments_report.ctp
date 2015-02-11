<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-05
 * Time: 5:42 PM
 */
?>
<div class='upper-right-opt, no-print'>
    <A HREF="javascript:window.print()">
        <?php echo $this->Html->image('print.jpg', array('alt' => 'Print')); ?>
    </A>
</div>
<?php
if($enrollments) {

//creating our table

    // loop through the enrollments records
    $last_co = null;
    $first_loop = true;
    $enrollment_count = 0;
    foreach ($enrollments as $enrollment) {
        if($last_co != $enrollment['Course']['course_code'].':'.$enrollment['CourseOffering']['date'].':'.$enrollment['I']['id'] ){
            if($first_loop){
                $first_loop = false;
            }else{
                echo "<tr><td><b>Count : ".$enrollment_count."</b></td></tr>";
                $enrollment_count = 0;
                echo "<tr><td><p class='breakhere'>&nbsp;</p></td></tr>";
                echo "</table>";
            }
            echo "<b>".$enrollment['Course']['course_code']." - ".$enrollment['Course']['description']."</b>&nbsp;(".
                 $enrollment['CourseOffering']['date']."), ".$enrollment['I']['first_name']."&nbsp;".$enrollment['I']['last_name'];
            echo "<br><br>";
            echo "<table>";

            echo "<tr>";

            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>Work Email</th>";
            echo "<th>Name on Certificate</th>";
            echo "</tr>";

            $last_co = $enrollment['Course']['course_code'].':'.$enrollment['CourseOffering']['date'].':'.$enrollment['I']['id'];
        }
        echo "<tr>";
        echo "<td>{$enrollment['EE']['first_name']}</td>";
        echo "<td>{$enrollment['EE']['last_name']}</td>";
        echo "<td>{$enrollment['EE']['work_email']}</td>";
        echo "<td>{$enrollment['EE']['name_on_certificate']}</td>";
        echo "</tr>";
        $enrollment_count++;
    }
    echo "<tr><td><b>Count : ".$enrollment_count."</b></td></tr>";
    echo "</table>";
}else{
    echo "No people found.";
}
?>
