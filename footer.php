			<div style="clear:both"></div>
			</div> <!-- end .center -->
			<footer class="footer" role="contentinfo">

				<div id="inner-footer" class="wrap clearfix">

					<?php dynamic_sidebar( 'footer' ); ?>

					<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?></p>

				</div> <!-- end #inner-footer -->

			</footer> <!-- end footer -->
			
		</div> <!-- end #container -->

		<!-- all js scripts are loaded in library/bones.php -->
		<?php wp_footer(); ?>

	</body>

</html> <!-- end page. what a ride! -->
