<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-06
 * Time: 6:29 PM
 */
?>
<?php
header('Content-Disposition: attachment; filename="downloaded.pdf"');
echo $content_for_layout;
?>