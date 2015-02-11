<!-- File: /app/View/People/index.ctp -->

<h2>ALL Instructors</h2>
<!-- link to add new users page -->
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'Add New Instructors', array( 'action' => 'search' ) ); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Back', '/pages/admin_menu'); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>

<table>
    <tr>
        <th>Instructor Id</th>
        <th>Id</th>
        <th>First</th>
        <th>Last</th>
        <th>Work Email</th>
        <th>Personal Email</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <!-- Here is where we loop through our $people array, printing out people info -->

    <?php foreach ($instructors as $instructor): ?>
        <tr>
            <td><?php echo $instructor['Instructor']['id']; ?></td>
            <td><?php echo $instructor['Person']['id']; ?></td>
            <td><?php echo $instructor['Person']['first_name']; ?></td>
            <td><?php echo $instructor['Person']['last_name']; ?></td>
            <td><?php echo $instructor['Person']['work_email']; ?></td>
            <td><?php echo $instructor['Person']['personal_email']; ?></td>
            <td><?php
                $status = $instructor['Instructor']['inactive'];
                if($status){
                    echo 'INACTIVE';
                } ?>
            </td>
            <td class='actions'>
            <?php
                if($status) {
                    echo $this->Form->postLink('Re-activate', array(
                        'action' => 'reactivate',
                        $instructor['Instructor']['id']), array(
                        'confirm' => 'Are you sure you want to re-activate that Instructor?'));
                }else{
                    echo $this->Form->postLink('De-Activate', array(
                        'action' => 'remove',
                        $instructor['Instructor']['id']), array(
                        'confirm' => 'Are you sure you want to de-activate that Instructor?'));
                }?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php unset($instructor); ?>
</table>
