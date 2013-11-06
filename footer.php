			<div style="clear:both"></div>
			</div> <!-- end .center -->
			<?php 
						$footer_attachment_id = get_field('footer_logo','option');
						$footer_img_size = "thumbnail";
						$footer_img_size_retina = "medium";
						 
						$footer_logo = wp_get_attachment_image_src( $footer_attachment_id, $footer_img_size );
						$footer_logo_retina = wp_get_attachment_image_src( $footer_attachment_id, $footer_img_size_retina );


			?>
			<footer class="footer" role="contentinfo">
				<?php if ($footer_logo) { ?>
				<div class="footer-logo no-retina" style="background-image: url('<?php echo $footer_logo[0]; ?>'); height:<?php echo $footer_logo[1]; ?>px;"></div>
				<div class="footer-logo retina" style="background-image: url('<?php echo $footer_logo_retina[0]; ?>'); height:<?php echo $footer_logo[1] ?>px;"></div>
				<?php } ?>
				<div id="inner-footer" class="wrap clearfix">

					<?php dynamic_sidebar( 'footer' ); ?>


					<div style="clear:both"></div>
					<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?></p>

				</div> <!-- end #inner-footer -->

			</footer> <!-- end footer -->
			
		</div> <!-- end #container -->

		<!-- all js scripts are loaded in library/bones.php -->
		<?php wp_footer(); ?>

	</body>

</html> <!-- end page. what a ride! -->
