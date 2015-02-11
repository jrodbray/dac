<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-09
 * Time: 7:07 PM
 */
?>
<!-- File: /app/View/People/index.ctp -->

<h2>ALL Instructional Organizations</h2>
<!-- link to add new users page -->
<div class='upper-right-opt'>
    <?php echo $this->Html->link( 'Add New Instructional Organizations', array( 'action' => 'add' ) ); ?>
&nbsp;&nbsp;
<?php echo $this->Html->link( 'Back', '/pages/admin_menu'); ?>
&nbsp;&nbsp;
<?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>

<table>
    <tr>
        <th>Id</th>
        <th>Code</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th>City</th>
        <th>Prov/State</th>
        <th>Country</th>
        <th>Action</th>
    </tr>

    <!-- Here is where we loop through our $people array, printing out people info -->

    <?php foreach ($entities as $entity): ?>
        <tr>
            <td><?php echo $entity['Entity']['id']; ?></td>
            <td><?php echo $entity['Entity']['code']; ?></td>
            <td><?php echo $entity['Entity']['name']; ?></td>
            <td><?php echo $entity['Entity']['phone']; ?></td>
            <td><?php echo $entity['Entity']['address1']." ".$entity['Entity']['address2'] ; ?></td>
            <td><?php echo $entity['Entity']['city']; ?></td>
            <td><?php echo $entity['Entity']['prov_state']; ?></td>
            <td><?php echo $entity['Entity']['country']; ?></td>
            <td class='actions'>
                <?php
                    echo $this->Html->link('Edit', array('action' => 'edit', $entity['Entity']['id']));
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php unset($entity); ?>
</table>
