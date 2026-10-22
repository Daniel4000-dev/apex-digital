<?php
/**
 * Template Name: Contact Page: Editorial Studio Aesthetic
 *
 * @package Agency_Site
 */

get_header();

// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$selected_service = isset( $_GET['service'] ) ? sanitize_text_field( wp_unslash( $_GET['service'] ) ) : '';
?>

<!-- Header Section -->
<section class="py-16 md:py-24 border-b border-ink/15 bg-ivory">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<span class="font-mono text-xs uppercase tracking-widest text-ink/60 block mb-3">01 / PROJECT INQUIRIES</span>
		<h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-ink tracking-tight font-heading mb-6 leading-tight">
			Start a <span class="font-serif italic font-normal text-cobalt">Project Conversation</span>
		</h1>
		<p class="text-lg sm:text-xl text-ink/80 max-w-2xl mx-auto leading-relaxed font-normal">
			<?php esc_html_e( 'Connect directly with our engineering and growth team. We review your site architecture and respond within 24 hours with an actionable roadmap.', 'agency-site' ); ?>
		</p>
	</div>
</section>

<!-- Main Contact Area -->
<section class="py-16 lg:py-24 bg-ivory">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
			
			<!-- Left Column: Editorial Contact Form (7 cols) -->
			<div class="lg:col-span-7">
				<div class="border border-ink/20 p-8 sm:p-12 bg-ivory">
					<span class="font-mono text-xs uppercase tracking-widest text-cobalt block mb-2">PROPOSAL BRIEF</span>
					<h2 class="text-2xl font-bold text-ink font-heading mb-2"><?php esc_html_e( 'Request a Technical Scope', 'agency-site' ); ?></h2>
					<p class="text-sm text-ink/70 mb-8"><?php esc_html_e( 'Tell us about your website, current performance bottlenecks, and target timeline.', 'agency-site' ); ?></p>

					<?php if ( ! class_exists( 'Agency_Core_Enquiry_Handler' ) && current_user_can( 'activate_plugins' ) ) : ?>
						<div class="mb-6 p-4 border border-amber-300 bg-amber-50 text-amber-900 text-xs sm:text-sm">
							<p class="font-bold mb-1">⚠️ Administrator Notice:</p>
							<p>The companion plugin <code>Agency Site Core</code> is currently inactive. Inquiries are being routed via the fallback direct email handler. Activate the plugin in <a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>" class="underline font-semibold">wp-admin</a> for dashboard CPT storage and automated webhook dispatch.</p>
						</div>
					<?php endif; ?>

					<?php
					$gf_form_id = apply_filters( 'agency_contact_gravity_form_id', get_option( 'agency_gravity_form_id', 0 ) );
					if ( ! empty( $gf_form_id ) && function_exists( 'gravity_form' ) ) :
						gravity_form( (int) $gf_form_id, false, true, false, null, true );
					else :
						?>

					<!-- Alert Box for AJAX responses -->
					<div id="contact-form-alert" class="hidden mb-6 p-4 border text-sm font-mono" role="alert"></div>

					<form id="agency-contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" class="space-y-6">
						<input type="hidden" name="action" value="agency_submit_contact">
						<input type="hidden" name="security" value="<?php echo esc_attr( wp_create_nonce( 'agency_contact_action_nonce' ) ); ?>">

						<!-- Anti-Spam Honeypot Field -->
						<div class="hidden" aria-hidden="true" style="display:none !important;">
							<label for="agency_hp_website">Leave this field blank</label>
							<input type="text" id="agency_hp_website" name="agency_hp_website" tabindex="-1" autocomplete="off">
						</div>

						<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
							<div>
								<label for="contact-name" class="block font-mono text-xs uppercase tracking-wider text-ink mb-2">
									Full Name <span class="text-coral">*</span>
								</label>
								<input 
									type="text" 
									id="contact-name" 
									name="name" 
									required 
									placeholder="Sarah Jenkins"
									class="w-full px-4 py-3 bg-ivory border border-ink/20 text-ink text-sm focus:outline-none focus:border-cobalt transition-colors"
								>
							</div>

							<div>
								<label for="contact-email" class="block font-mono text-xs uppercase tracking-wider text-ink mb-2">
									Work Email <span class="text-coral">*</span>
								</label>
								<input 
									type="email" 
									id="contact-email" 
									name="email" 
									required 
									placeholder="sarah@company.com"
									class="w-full px-4 py-3 bg-ivory border border-ink/20 text-ink text-sm focus:outline-none focus:border-cobalt transition-colors"
								>
							</div>
						</div>

						<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
							<div>
								<label for="contact-phone" class="block font-mono text-xs uppercase tracking-wider text-ink mb-2">
									Phone Number
								</label>
								<input 
									type="tel" 
									id="contact-phone" 
									name="phone" 
									placeholder="+1 (555) 000-0000"
									class="w-full px-4 py-3 bg-ivory border border-ink/20 text-ink text-sm focus:outline-none focus:border-cobalt transition-colors"
								>
							</div>

							<div>
								<label for="contact-company" class="block font-mono text-xs uppercase tracking-wider text-ink mb-2">
									Company / Website URL
								</label>
								<input 
									type="text" 
									id="contact-company" 
									name="company" 
									placeholder="yourcompany.com"
									class="w-full px-4 py-3 bg-ivory border border-ink/20 text-ink text-sm focus:outline-none focus:border-cobalt transition-colors"
								>
							</div>
						</div>

						<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
							<div>
								<label for="contact-service" class="block font-mono text-xs uppercase tracking-wider text-ink mb-2">
									Primary Service Needed
								</label>
								<select 
									id="contact-service" 
									name="service" 
									class="w-full px-4 py-3 bg-ivory border border-ink/20 text-ink text-sm focus:outline-none focus:border-cobalt transition-colors"
								>
									<option value="Full-Funnel Growth Retainer" <?php selected( $selected_service, '' ); ?>>Full-Funnel Growth Retainer</option>
									<option value="Website Design & Engineering" <?php selected( $selected_service, 'Website Design & Engineering' ); ?>>Website Design & Engineering</option>
									<option value="Search Engine Optimization (SEO)" <?php selected( $selected_service, 'Search Engine Optimization (SEO)' ); ?>>Search Engine Optimization (SEO)</option>
									<option value="Paid Media & Performance Ads" <?php selected( $selected_service, 'Paid Media & Performance Ads' ); ?>>Paid Media & Performance Ads</option>
									<option value="Conversion Rate Optimization (CRO)" <?php selected( $selected_service, 'Conversion Rate Optimization (CRO)' ); ?>>Conversion Rate Optimization (CRO)</option>
								</select>
							</div>

							<div>
								<label for="contact-budget" class="block font-mono text-xs uppercase tracking-wider text-ink mb-2">
									Estimated Monthly Budget
								</label>
								<select 
									id="contact-budget" 
									name="budget" 
									class="w-full px-4 py-3 bg-ivory border border-ink/20 text-ink text-sm focus:outline-none focus:border-cobalt transition-colors"
								>
									<option value="$3,000 - $5,000 / month">$3,000 - $5,000 / mo</option>
									<option value="$5,000 - $10,000 / month" selected>$5,000 - $10,000 / mo</option>
									<option value="$10,000 - $25,000 / month">$10,000 - $25,000 / mo</option>
									<option value="$25,000+ / month">$25,000+ / mo</option>
									<option value="One-Time Strategic Project">One-Time Strategic Project</option>
								</select>
							</div>
						</div>

						<div>
							<label for="contact-message" class="block font-mono text-xs uppercase tracking-wider text-ink mb-2">
								Project Objectives & Current Challenges <span class="text-coral">*</span>
							</label>
							<textarea 
								id="contact-message" 
								name="message" 
								rows="5" 
								required
								placeholder="Describe your current site setup, traffic sources, and core goals for this engagement..."
								class="w-full px-4 py-3 bg-ivory border border-ink/20 text-ink text-sm focus:outline-none focus:border-cobalt transition-colors"
							></textarea>
						</div>

						<div>
							<button 
								id="contact-submit-btn" 
								type="submit" 
								class="btn-primary w-full !py-4 text-xs uppercase tracking-wider font-bold"
							>
								<span id="submit-spinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
								<span id="submit-text">Request Strategy Consultation</span>
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
							</button>
							<p class="font-mono text-[11px] text-center text-ink/50 mt-3">
								🔒 Privacy guaranteed. No cold sales follow-ups or synthetic lists.
							</p>
						</div>
					</form>
					<?php endif; ?>
				</div>
			</div>

			<!-- Right Column: Direct Contact & Guarantees (5 cols) -->
			<div class="lg:col-span-5 space-y-8">
				
				<!-- Direct Communication Card -->
				<div class="border border-ink/20 p-8 bg-ivory space-y-6">
					<span class="font-mono text-xs uppercase tracking-widest text-ink/60 block">STUDIO DESK</span>
					<h3 class="text-xl font-bold text-ink font-heading"><?php esc_html_e( 'Direct Communication', 'agency-site' ); ?></h3>
					
					<div class="space-y-4 text-sm font-mono">
						<div>
							<span class="text-ink/60 block text-xs">Direct Email:</span>
							<a href="mailto:<?php echo esc_attr( get_theme_mod( 'agency_email', 'growth@apexagency.digital' ) ); ?>" class="text-ink font-bold hover:text-cobalt underline">
								<?php echo esc_html( get_theme_mod( 'agency_email', 'growth@apexagency.digital' ) ); ?>
							</a>
						</div>

						<div>
							<span class="text-ink/60 block text-xs">Response Commitment:</span>
							<span class="text-ink font-bold">Within 24 business hours</span>
						</div>

						<div>
							<span class="text-ink/60 block text-xs">Direct Phone:</span>
							<span class="text-ink font-bold">+1 (800) 555-APEX</span>
						</div>

						<div>
							<span class="text-ink/60 block text-xs">Operating Hours:</span>
							<span class="text-ink font-bold">Monday – Friday · 09:00 – 18:00 EST</span>
						</div>
					</div>
				</div>

				<!-- What Happens Next -->
				<div class="border border-ink/20 p-8 bg-ivory space-y-4">
					<span class="font-mono text-xs uppercase tracking-widest text-cobalt block font-bold">THE PROCESS</span>
					<h3 class="text-lg font-bold text-ink font-heading"><?php esc_html_e( 'What Happens Next?', 'agency-site' ); ?></h3>
					<ol class="space-y-3 font-mono text-xs text-ink/80">
						<li class="flex items-start gap-2">
							<span class="font-bold text-cobalt">1.</span>
							<span>We audit your domain, current page speed, and keyword footprint.</span>
						</li>
						<li class="flex items-start gap-2">
							<span class="font-bold text-cobalt">2.</span>
							<span>A senior technical architect schedules a 30-minute scoping call.</span>
						</li>
						<li class="flex items-start gap-2">
							<span class="font-bold text-cobalt">3.</span>
							<span>You receive a transparent statement of work with deliverables and pricing.</span>
						</li>
					</ol>
				</div>

			</div>

		</div>
	</div>
</section>

<?php
get_footer();
