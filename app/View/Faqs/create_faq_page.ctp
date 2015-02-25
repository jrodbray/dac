<?php
/**
 * Created by PhpStorm.
 * User: Rod
 * Date: 2015-02-19
 * Time: 2:48 PM
 */
?>
<section class="cd-faq">
    <ul class="cd-faq-categories">
        <?php
        foreach ($sections as $section):
        ?>
            <li><a href="#<?php echo $section['Section']['name']; ?>" ><?php echo $section['Section']['name']; ?></a></li>
        <?php
        endforeach;
        ?>
    </ul> <!-- cd-faq-categories -->

    <div class="cd-faq-items">
    <?php
    $first = true;
    $last_section_name = '';
    foreach ($faqs as $faq):
        $section_name = $faq['Section']['name'];
        if ($last_section_name != $section_name){
            if( !$first ){
                echo '</ul>';
            }
            echo '<ul id="'.$section_name.'" class="cd-faq-group">';
            $last_section_name = $section_name;
            echo '<li class="cd-faq-title"><h2>'.$section_name.'</h2></li>';

        }
        echo '<li>';
        echo '<a class="cd-faq-trigger" href="#0">'.$faq['Faq']['question'].'</a>';
            echo '<div class="cd-faq-content">';
            //        <!-- content here -->
            echo $faq['Faq']['answer'];
            echo '</div>';
        echo '</li>';
    endforeach;
    ?>
    </ul>
</div>
<a href="#0" class="cd-close-panel">Close</a>
</section>