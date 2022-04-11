<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bhari
 */

?>
    <?php bhari_content_bottom(); ?>
    </div><!-- #content -->
    <?php bhari_content_after(); ?>

    <?php bhari_footer_before(); ?>
    <footer id="colophon" class="site-footer" role="contentinfo">
    <?php bhari_footer_top(); ?>

        <div class="site-info">           

		  <p>Уроки чтения. Домашняя лаборатория начального литературного образования — НЛО</p>
		  <p>Сайт Александра Васильевича Охрименко</p>
		<h3>2018</h3>
			

            
        </div><!-- .site-info -->

    <?php bhari_footer_bottom(); ?>
    </footer><!-- #colophon -->
    <?php bhari_footer_after(); ?>

</div><!-- #page -->

<?php bhari_body_bottom(); ?>
<?php wp_footer(); ?>

</body>
</html>
