<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-01-14
 * Time: 10:11 AM
 */
?>
<h2>DAC Student Database</h2>

<?php
echo $this->Html->link( 'People Menu',     '/pages/people_menu');
?>
<br><br>
<?php
echo $this->Html->link( 'Admin Menu',     '/pages/admin_menu');
?>
<br><br>
<?php
echo $this->Html->link( 'Course Offerings',     array(
    'controller' => 'courseOfferings',
    'action' => 'index',
    'full_base' => true
));
?>
<br><br>
<?php
echo $this->Html->link( 'Enrollment Menu',     '/pages/enrollments_menu');
?>
<br><br>
<?php
    echo $this->Html->link( 'Report Builder', '/report_manager/reports');
?>