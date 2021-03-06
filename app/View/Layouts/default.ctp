<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>

<head>
	<?php echo $this->Html->charset(); ?>

	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		//echo $this->fetch('meta');
		//echo $this->fetch('css');
		echo $this->Html->css('jquery-ui.min');
		//echo $this->Html->css('jquery-ui.structure.min');
		//echo $this->Html->css('jquery-ui.theme.min');

		//echo $this->fetch('script');
		echo $this->Html->script('jquery');
		echo $this->Html->script('jquery-ui.min');

	?>
	<script>
		$(function() {
			$( "#datepicker" ).datepicker({dateFormat: "yy-mm-dd"});
			$( "#datepicker2" ).datepicker({dateFormat: "yy-mm-dd"});

			$( "#PersonLastName" ).on("change", function () {
				var $nameArray = [$("#PersonFirstName").val(), $("#PersonLastName").val()];
				$("#PersonNameOnCertificate").val($nameArray.join(' '));
			});

            $( "#workEmailForm").on("submit", function () {
               $("#email_key").val( $("#autocomplete").val() );
            });

            //$('#autocomplete').autocomplete({source: "http://scottambler.com/dac/People/getWorkEmail.json"});
            $('#autocomplete').autocomplete({source: "http://localhost/dac/People/getWorkEmail.json"});
		});
	</script>
    <style>
        #progressbar .ui-progressbar-value {
            background-color: #ccc;
        }
    </style>

</head>
<body>
	<div id="container">
		<div id="header" class="no-print">
			<h1>
            <?php echo
                $this->Html->link('FAQ', array(
                    'controller' => 'faqs',
                    'action' => 'create_faq_page'
                ),
                    //'/pages/help',
                array('target' => '_blank') );
            ?>
            </h1>
		</div>
		<div id="content">
			<div class="no-print">
			<?php echo $this->Session->flash(); ?>
			</div>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer" class="no-print">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php echo $this->Html->link('Return to Main', '/'); ?>
			</p>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div>
	</div>
	<div class="no-print">
	<?php
    if( !Configure::read('dac.production') ) {
        echo $this->element('sql_dump');
    }
    ?>
	</div>
</body>
</html>
