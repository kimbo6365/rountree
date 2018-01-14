			<!-- footer -->
			<footer class="footer <?php if (is_front_page()) echo 'no-margin'; ?>" role="contentinfo">
			<button class="btn btn-default btn-lg btn-info js-trigger-email-newsletter-modal">Join the mailing list!</button>
				<!-- copyright -->
				<p class="copyright">
					&copy; <?php echo date('Y'); ?> Copyright <?php bloginfo('name');  ?>. All rights reserved.
				</p>
				<!-- /copyright -->

			</footer>
			<!-- /footer -->
			<?php
				$classesList = get_posts(['post_type' => ['class', 'workshop']]);
				$output = '';
				foreach($classesList as $index => $post) {
					$output .= '<div class="js-classes-select-option" data-class-id="'. $post->ID .'" data-class-name="'. $post->post_title .'"></div>';
				}
				echo $output;
			?>
			
			
			<div class="modal fade js-request-class-modal">
				<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h5 class="modal-title">Request a Class</h5>
					</div>
					<div class="modal-body">
						<?php echo do_shortcode('[ninja_form id=3]'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade js-detailed-directions-modal">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title"></h5>
				</div>
				<div class="modal-body"></div>
			</div>
		</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>

		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
		ga('send', 'pageview');
		</script>

	</body>
</html>
