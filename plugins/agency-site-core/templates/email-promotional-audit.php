<?php
/**
 * Promotional Campaign HTML Email Template
 *
 * Subject: Turn More Visits Into Enquiries — Complimentary Q4 Growth Audit
 * Purpose: Complete promotional marketing campaign email featuring accessible table structure,
 * inline styles, MSO conditionals, image fallbacks, and plain-text alternative.
 *
 * Variables in scope:
 * - $recipient_name
 * - $recipient_company
 * - $audit_url
 * - $site_name
 * - $agency_email
 *
 * @package Agency_Site_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$recipient_name    = isset( $recipient_name ) && ! empty( $recipient_name ) ? esc_html( $recipient_name ) : 'Growth Leader';
$recipient_company = isset( $recipient_company ) && ! empty( $recipient_company ) ? esc_html( $recipient_company ) : 'your company';
$site_name         = ! empty( $site_name ) ? esc_html( $site_name ) : get_bloginfo( 'name' );
$audit_url         = ! empty( $audit_url ) ? esc_url( $audit_url ) : home_url( '/contact/?utm_source=email&utm_campaign=q4_growth_audit' );
$agency_email      = ! empty( $agency_email ) ? sanitize_email( $agency_email ) : 'growth@apexagency.digital';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo esc_html( sprintf( 'Growth Architecture Review — %s', $site_name ) ); ?></title>
	<style type="text/css">
		/* Client-specific resets */
		body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
		table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
		img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
		table { border-collapse: collapse !important; }
		body { margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #f1f5f9; }
		@media screen and (max-width: 620px) {
			.email-container { width: 100% !important; max-width: 100% !important; }
			.fluid-padding { padding-left: 20px !important; padding-right: 20px !important; }
			.stack-column { display: block !important; width: 100% !important; }
		}
	</style>
	<!--[if mso]>
	<style type="text/css">
		body, table, td, h1, h2, h3, p, a { font-family: Arial, sans-serif !important; }
	</style>
	<![endif]-->
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b;">

	<!-- Preheader text (visible in inbox preview, hidden in body) -->
	<div style="display: none; max-height: 0px; overflow: hidden; font-size: 1px; line-height: 1px; color: #f1f5f9; opacity: 0;">
		Turn more visits into enquiries. Discover the 3 conversion leaks quietly capping your growth this quarter.
	</div>

	<!-- Outer Background Table -->
	<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f1f5f9; padding: 32px 12px;">
		<tr>
			<td align="center" valign="top">
				
				<!-- Main Email Card (600px Max Width) -->
				<!--[if (gte mso 9)|(IE)]>
				<table role="presentation" align="center" border="0" cellspacing="0" cellpadding="0" width="600">
				<tr>
				<td align="center" valign="top" width="600">
				<![endif]-->
				<table role="presentation" class="email-container" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #cbd5e1; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);">
					
					<!-- Header Banner -->
					<tr>
						<td style="background-color: #0b1528; padding: 36px 36px 28px 36px; text-align: left;" class="fluid-padding">
							<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td>
										<div style="display: inline-block; background-color: rgba(14, 140, 233, 0.2); border: 1px solid rgba(14, 140, 233, 0.4); color: #38bdf8; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 4px 12px; border-radius: 9999px; margin-bottom: 14px;">
											Strategy Advisory
										</div>
										<h1 style="color: #ffffff; font-size: 24px; font-weight: 800; margin: 0; line-height: 1.3; letter-spacing: -0.5px;">
											<?php echo esc_html( $site_name ); ?>
										</h1>
										<p style="color: #94a3b8; font-size: 13px; margin: 6px 0 0 0; line-height: 1.4;">
											Performance Web Design • Search Visibility • Conversion Optimization
										</p>
									</td>
								</tr>
							</table>
						</td>
					</tr>

					<!-- Hero Proposition -->
					<tr>
						<td style="padding: 36px 36px 20px 36px;" class="fluid-padding">
							<h2 style="color: #0f172a; font-size: 22px; font-weight: 800; margin: 0 0 16px 0; line-height: 1.3;">
								Turn more visits into enquiries.
							</h2>
							<p style="color: #475569; font-size: 15px; line-height: 1.6; margin: 0 0 16px 0;">
								Hi <?php echo esc_html( $recipient_name ); ?>,
							</p>
							<p style="color: #475569; font-size: 15px; line-height: 1.6; margin: 0 0 20px 0;">
								Most growing businesses invest heavily in traffic, only to lose high-intent buyers to slow pages, fragmented search intent, or confusing mobile enquiry paths.
							</p>
							<p style="color: #475569; font-size: 15px; line-height: 1.6; margin: 0 0 28px 0;">
								For a limited window this quarter, the strategy team at <strong><?php echo esc_html( $site_name ); ?></strong> is conducting complimentary, human-reviewed <strong>Growth &amp; Conversion Audits</strong> for selected businesses.
							</p>

							<!-- Feature Box: What the Audit Delivers -->
							<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 28px;">
								<tr>
									<td style="padding: 24px;">
										<h3 style="color: #0369a1; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; margin: 0 0 16px 0;">
											What Your Audit Evaluates:
										</h3>
										
										<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 12px;">
											<tr>
												<td width="24" valign="top" style="color: #0284c7; font-weight: bold; font-size: 16px; line-height: 1.4;">✓</td>
												<td style="padding-left: 8px; color: #1e293b; font-size: 14px; line-height: 1.5;">
													<strong>High-Intent Search Mapping:</strong> Uncover keyword clusters where your competitors capture leads you should be winning.
												</td>
											</tr>
										</table>

										<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 12px;">
											<tr>
												<td width="24" valign="top" style="color: #0284c7; font-weight: bold; font-size: 16px; line-height: 1.4;">✓</td>
												<td style="padding-left: 8px; color: #1e293b; font-size: 14px; line-height: 1.5;">
													<strong>Mobile Conversion Leaks:</strong> Pinpoint awkward tap targets, slow LCP bottlenecks, and friction points in your contact form.
												</td>
											</tr>
										</table>

										<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td width="24" valign="top" style="color: #0284c7; font-weight: bold; font-size: 16px; line-height: 1.4;">✓</td>
												<td style="padding-left: 8px; color: #1e293b; font-size: 14px; line-height: 1.5;">
													<strong>Clear 90-Day Execution Plan:</strong> 3 concrete sprint priorities you can execute immediately with your internal team or agency.
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>

							<!-- Bulletproof Call-To-Action Button -->
							<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 32px;">
								<tr>
									<td align="center">
										<!--[if mso]>
										<v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="<?php echo esc_url( $audit_url ); ?>" style="height:48px;v-text-anchor:middle;width:280px;" arcsize="18%" stroke="f" fillcolor="#0284c7">
										<w:anchorlock/>
										<center style="color:#ffffff;font-family:Arial,sans-serif;font-size:15px;font-weight:bold;">Claim Your Strategy Audit &rarr;</center>
										</v:roundrect>
										<![endif]-->
										<!--[if !mso]><!-->
										<a href="<?php echo esc_url( $audit_url ); ?>" style="background-color: #0284c7; color: #ffffff; display: inline-block; font-size: 15px; font-weight: 700; text-decoration: none; padding: 15px 36px; border-radius: 8px; text-align: center; box-shadow: 0 4px 6px -1px rgba(2, 132, 199, 0.3);">
											Claim Your Strategy Audit &rarr;
										</a>
										<!--<![endif]-->
									</td>
								</tr>
							</table>

							<p style="color: #64748b; font-size: 13px; line-height: 1.5; text-align: center; margin: 0 0 24px 0;">
								🔒 No automated scan reports. Every audit is prepared by a human growth strategist.
							</p>

						</td>
					</tr>

					<!-- Separator -->
					<tr>
						<td style="padding: 0 36px;" class="fluid-padding">
							<hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 0;" />
						</td>
					</tr>

					<!-- Footer & Compliance -->
					<tr>
						<td style="background-color: #f8fafc; padding: 28px 36px; text-align: center;" class="fluid-padding">
							<p style="color: #94a3b8; font-size: 12px; line-height: 1.6; margin: 0 0 8px 0;">
								&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $site_name ); ?>. All rights reserved.
							</p>
							<p style="color: #94a3b8; font-size: 11px; line-height: 1.5; margin: 0 0 12px 0;">
								Apex Digital is a fictional agency portfolio project created for demonstration and technical assessment.
							</p>
							<p style="color: #94a3b8; font-size: 11px; line-height: 1.5; margin: 0;">
								Direct contact: <a href="mailto:<?php echo esc_attr( $agency_email ); ?>" style="color: #0284c7; text-decoration: underline;"><?php echo esc_html( $agency_email ); ?></a>
								&nbsp;|&nbsp;
								<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" style="color: #0284c7; text-decoration: underline;">Preferences &amp; Unsubscribe</a>
							</p>
						</td>
					</tr>

				</table>
				<!--[if (gte mso 9)|(IE)]>
				</td>
				</tr>
				</table>
				<![endif]-->

			</td>
		</tr>
	</table>

</body>
</html>
