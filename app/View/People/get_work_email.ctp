<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-24
 * Time: 2:18 PM
 */

?>
<h2>Trying Autocomplete by Work Email</h2>

<?php
    echo 'Work Email Autocomplete Form';
  //form with autocomplete class field
  echo $this->Form->create(false);
  echo $this->Form->input('workEmail', array('class' => 'ui-widget', 'id' => 'autocomplete'));
  echo $this->Form->end();
?>