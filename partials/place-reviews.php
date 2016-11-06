<div class="reviews">
    <?php 
    if (comments_open() || get_comments_number()) :
        comments_template();
    endif;
    ?>
    <!--review end-->
    <!--add comment-->
    <div class="add_comment">

    </div>
</div>