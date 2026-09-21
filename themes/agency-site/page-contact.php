<?php
/**
 * Template Name: Contact Page
 *
 * @package Agency_Site
 */

get_header();

// phpcs:ignore WordPress.Security.NonceVerification.Recommended
$selected_service = isset( $_GET['service'] ) ? sanitize_text_field( wp_unslash( $_GET['service'] ) ) : '';
?>

<!-- Header Section -->
<section class="py-16 md:py-20 bg-gradient-to-b from-white via-agency-50/40 to-slate-50 border-b border-slate-200/60">
	<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<span class="badge-tag mb-4">Start Scaling</span>
		<h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight font-heading mb-6">
			Let’s Build Your Next Growth Breakthrough
		</h1>
		<p class="text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
			Fill out the form below to connect with a senior growth architect. We respond within 24 hours with an initial review of your market opportunity.
		</p>
	</div>
</section>

<!-- Main Contact Area -->
<section class="py-16 lg:py-24 bg-slate-50">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
			
			<!-- Left Column: Contact Form (7 cols) -->
			<div class="lg:col-span-7">
				<div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/80 shadow-soft">
					<h2 class="text-2xl font-bold text-slate-900 font-heading mb-2">Book a Strategy Consultation</h2>
					<p class="text-sm text-slate-600 mb-8">Tell us about your brand, current growth metrics, and where you want to scale.</p>

					<!-- Alert Box for AJAX responses -->
					<div id="contact-form-alert" class="hidden mb-6 p-4 rounded-2xl text-sm" role="alert"></div>

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
								<label for="contact-name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
									Full Name <span class="text-red-500">*</span>
								</label>
								<input 
									type="text" 
									id="contact-name" 
									name="name" 
									required 
									placeholder="Sarah Jenkins"
									class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-agency-500 focus:border-agency-500 transition-colors"
								>
							</div>

							<div>
								<label for="contact-email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
									Work Email <span class="text-red-500">*</span>
								</label>
								<input 
									type="email" 
									id="contact-email" 
									name="email" 
									required 
									placeholder="sarah@company.com"
									class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-agency-500 focus:border-agency-500 transition-colors"
								>
							</div>
						</div>

						<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
							<div>
								<label for="contact-phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
									Phone Number
								</label>
								<input 
									type="tel" 
									id="contact-phone" 
									name="phone" 
									placeholder="+1 (555) 000-0000"
									class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-agency-500 focus:border-agency-500 transition-colors"
								>
							</div>

							<div>
								<label for="contact-company" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
									Company / Website URL
								</label>
								<input 
									type="text" 
									id="contact-company" 
									name="company" 
									placeholder="yourbrand.com"
									class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-agency-500 focus:border-agency-500 transition-colors"
								>
							</div>
						</div>

						<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
							<div>
								<label for="contact-service" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
									Primary Capability Needed
								</label>
								<select 
									id="contact-service" 
									name="service" 
									class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-agency-500 focus:border-agency-500 transition-colors"
								>
									<option value="Full-Funnel Growth Retainer" <?php selected( $selected_service, '' ); ?>>Full-Funnel Growth Retainer</option>
									<option value="Search Engine Optimization (SEO)" <?php selected( $selected_service, 'Search Engine Optimization (SEO)' ); ?>>Search Engine Optimization (SEO)</option>
									<option value="Paid Media & Performance Ads" <?php selected( $selected_service, 'Paid Media & Performance Ads)' ); ?>>Paid Media & Performance Ads</option>
									<option value="Conversion Rate Optimization (CRO)" <?php selected( $selected_service, 'Conversion Rate Optimization (CRO)' ); ?>>Conversion Rate Optimization (CRO)</option>
									<option value="Content Marketing & PR" <?php selected( $selected_service, 'Content Marketing & PR' ); ?>>Content Marketing & PR</option>
									<option value="Growth Web Development" <?php selected( $selected_service, 'Growth Web Development' ); ?>>Growth Web Development</option>
								</select>
							</div>

							<div>
								<label for="contact-budget" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
									Monthly Marketing Budget
								</label>
								<select 
									id="contact-budget" 
									name="budget" 
									class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-agency-500 focus:border-agency-500 transition-colors"
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
							<label for="contact-message" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
								Tell us about your goals & challenges <span class="text-red-500">*</span>
							</label>
							<textarea 
								id="contact-message" 
								name="message" 
								rows="5" 
								required
								placeholder="What are your target metrics? What channels are currently working or failing?"
								class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-agency-500 focus:border-agency-500 transition-colors"
							></textarea>
						</div>

						<div>
							<button 
								id="contact-submit-btn" 
								type="submit" 
								class="btn-primary w-full !py-4 text-base font-bold shadow-md hover:shadow-lg transition-all"
							>
								<span id="submit-spinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
								<span id="submit-text">Request Strategy Consultation</span>
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
							</button>
							<p class="text-[11px] text-center text-slate-400 mt-3">
								🔒 We respect your privacy. No spam. NDA provided upon request.
							</p>
						</div>
					</form>
				</div>
			</div>

			<!-- Right Column: Contact Cards & Process Info (5 cols) -->
			<div class="lg:col-span-5 space-y-8">
				
				<!-- Direct Contact Details Card -->
				<div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-soft space-y-6">
					<h3 class="text-xl font-bold text-slate-900 font-heading"><?php esc_html_e( 'Direct Communication', 'agency-site' ); ?></h3>
					
					<div class="space-y-5 text-sm">
						<div class="flex items-start gap-4">
							<div class="w-10 h-10 rounded-xl bg-agency-50 text-agency-600 flex items-center justify-center shrink-0">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
							</div>
							<div>
								<span class="text-xs text-slate-400 block font-semibold uppercase">Email Inquiries</span>
								<a href="mailto:<?php echo esc_attr( get_theme_mod( 'agency_email', 'growth@apexagency.digital' ) ); ?>" class="font-bold text-slate-800 hover:text-agency-600 transition-colors">
									<?php echo esc_html( get_theme_mod( 'agency_email', 'growth@apexagency.digital' ) ); ?>
								</a>
							</div>
						</div>

						<div class="flex items-start gap-4">
							<div class="w-10 h-10 rounded-xl bg-agency-50 text-agency-600 flex items-center justify-center shrink-0">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
							</div>
							<div>
								<span class="text-xs text-slate-400 block font-semibold uppercase"><?php esc_html_e( 'Response Timeframe', 'agency-site' ); ?></span>
								<p class="font-medium text-slate-700">
									<?php esc_html_e( 'We review incoming project enquiries Monday through Friday and respond with an initial assessment within one business day.', 'agency-site' ); ?>
								</p>
							</div>
						</div>

						<div class="flex items-start gap-4">
							<div class="w-10 h-10 rounded-xl bg-agency-50 text-agency-600 flex items-center justify-center shrink-0">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
							</div>
							<div>
								<span class="text-xs text-slate-400 block font-semibold uppercase"><?php esc_html_e( 'Project Confidentiality', 'agency-site' ); ?></span>
								<p class="font-medium text-slate-700">
									<?php esc_html_e( 'All project details, current metrics and discussions remain strictly confidential between our team and yours.', 'agency-site' ); ?>
								</p>
							</div>
						</div>
					</div>
				</div>

				<!-- What happens next card -->
				<div class="bg-gradient-to-br from-slate-900 to-dark-900 text-white rounded-3xl p-8 border border-slate-800 shadow-xl space-y-6">
					<h3 class="text-lg font-bold font-heading text-white">What Happens After You Submit:</h3>
					
					<div class="space-y-4 text-xs sm:text-sm text-slate-300">
						<div class="flex items-start gap-3">
							<span class="w-6 h-6 rounded-full bg-agency-500 text-white font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">1</span>
							<p><strong class="text-white">Initial Audit:</strong> We analyze your current search footprint, tech stack, and ad competitor history.</p>
						</div>
						<div class="flex items-start gap-3">
							<span class="w-6 h-6 rounded-full bg-agency-500 text-white font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">2</span>
							<p><strong class="text-white">Strategic Call:</strong> A 30-minute discovery session with our Lead Growth Architect (no salespeople).</p>
						</div>
						<div class="flex items-start gap-3">
							<span class="w-6 h-6 rounded-full bg-agency-500 text-white font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">3</span>
							<p><strong class="text-white">Custom Proposal:</strong> A transparent roadmap with milestone deliverables, timeline, and investment tiers.</p>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
</section>

<?php
get_footer();

