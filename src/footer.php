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
			<div class="modal fade js-join-waitlist-modal">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h5 class="modal-title">Join the waiting list</h5>
						</div>
						<div class="modal-body">
							<?php echo do_shortcode('[ninja_form id=4]'); ?>
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
			</div>
			<div class="modal fade js-email-newsletter-modal">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h5 class="modal-title">Stay In Touch</h5>
						</div>
						<div class="modal-body">
							<p>Thank you for supporting the arts; sign up to get emails around once a month about cool shows and discounts on classes!</p>
							<!-- Begin MailChimp Signup Form -->
							<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
							<style type="text/css">
								#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
								/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
									We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
							</style>
							<div id="mc_embed_signup">
								<form action="https://amandarountree.us17.list-manage.com/subscribe/post?u=fa6ebd084fa05a38e32721388&amp;id=13d3d1014a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
									<div id="mc_embed_signup_scroll">							
										<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
										<div class="mc-field-group">
											<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span></label>
											<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
										</div>
										<div class="mc-field-group">
											<label for="mce-FNAME">First Name </label>
											<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
										</div>
										<div class="mc-field-group">
											<label for="mce-LNAME">Last Name </label>
											<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
										</div>
										<div class="mc-field-group size1of2">
											<label for="mce-BIRTHDAY-month">Birthday </label>
											<div class="datefield">
												<span class="subfield monthfield"><input class="birthday " type="text" pattern="[0-9]*" value="" placeholder="MM" size="2" maxlength="2" name="BIRTHDAY[month]" id="mce-BIRTHDAY-month"></span> / 
												<span class="subfield dayfield"><input class="birthday " type="text" pattern="[0-9]*" value="" placeholder="DD" size="2" maxlength="2" name="BIRTHDAY[day]" id="mce-BIRTHDAY-day"></span> 
												<span class="small-meta nowrap">( mm / dd )</span>
											</div>
										</div>	
										<div id="mce-responses" class="clear">
											<div class="response" id="mce-error-response" style="display:none"></div>
											<div class="response" id="mce-success-response" style="display:none"></div>
										</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
										<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_fa6ebd084fa05a38e32721388_13d3d1014a" tabindex="-1" value=""></div>
										<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button btn btn-sm btn-primary"></div>
									</div>
								</form>
							</div>
							<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='BIRTHDAY';ftypes[3]='birthday';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
							<!--End mc_embed_signup-->
						</div>
					</div>
				</div>
			</div>
			<?php get_template_part('_payment_form'); ?>
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
