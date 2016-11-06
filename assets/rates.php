<?php

/**
 * echo the stars 
 * @param $s
 */
function mycity_stars($s)
{
    $s = esc_html($s);
    ?>
    <ul class="rate">
        <?php
        for ($i = 0; $i < $s; $i++) {
            ?>
            <li><i class="fa fa-star"></i></li><?php
        }
        ?>
    </ul>
    <?php
}

?>