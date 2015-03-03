<!-- File: /app/View/People/index.ctp -->
<?php
$active_filter = $this->Session->read('active_filter');
if($active_filter) {
    echo "<h2>Filter People</h2>";
    echo "<h3>".print_r($active_filter)."</h3>";
}else{
    echo "<h2>Browse People</h2>";
}
//print_r($people);
?>
<!-- link to add new users page -->
<div class='upper-right-opt'>
    <?php
    if($active_filter) {
        echo $this->Html->link('Clear Filter', array('action' => 'clear_filter'));
    } else{
        echo $this->Html->link('Filter People', array('action' => 'filter'));
    }
    ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Add New People', array( 'action' => 'add' ) ); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Back', '/pages/people_menu'); ?>
    &nbsp;&nbsp;
    <?php echo $this->Html->link( 'Home', '/pages/home'); ?>
</div>

<?php
$paginator = $this->Paginator;

if($people){

//creating our table
echo "<table>";

    // our table header, we can sort the data user the paginator sort() method!
    echo "<tr>";

        // in the sort method, the first parameter is the same as the column name in our table
        // the second parameter is the header label we want to display in the view
        echo "<th>" . $paginator->sort('id', 'ID') . "</th>";
        echo "<th>" . $paginator->sort('first_name', 'First Name') . "</th>";
        echo "<th>" . $paginator->sort('last_name', 'Last Name') . "</th>";
        echo "<th>" . $paginator->sort('work_email', 'Work Email') . "</th>";
        echo "<th>" . $paginator->sort('personal_email', 'Personal Email') . "</th>";
        echo "<th>Action </th>";
        echo "</tr>";

    // loop through the user's records
    foreach( $people as $person ){
    echo "<tr>";
        echo "<td>{$person['Person']['id']}</td>";
        echo "<td>{$person['Person']['first_name']}</td>";
        echo "<td>{$person['Person']['last_name']}</td>";
        echo "<td>{$person['Person']['work_email']}</td>";
        echo "<td>{$person['Person']['personal_email']}</td>";
        echo "<td class='actions'>";
        echo $this->Html->link( 'Edit', array('action' => 'edit', $person['Person']['id']) );
        //in cakephp 2.0, we won't use get request for deleting records
        //we use post request (for security purposes)
        echo $this->Form->postLink( 'Delete', array(
            'action' => 'delete',
            $person['Person']['id']), array(
            'confirm'=>'Are you sure you want to delete that Person?' ) );
        echo $this->Html->link( 'Course History', array('controller' => 'CourseOfferings', 'action' => 'course_details', $person['Person']['id']) );
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

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
echo "No people found.";
}
?>
<br>
<?php
//echo print_r($people);
?>
<br>
