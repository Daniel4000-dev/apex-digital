<?php
/**
 * HTML Internal Notification Email Template (sent to agency admins)
 *
 * @package Agency_Site_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>New Growth Inbound Lead</title>
	<style>
		body { margin: 0; padding: 0; background-color: #0b0f19; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #334155; }
		.wrapper { width: 100%; background-color: #0b0f19; padding: 40px 16px; }
		.container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; }
		.header { background: #0c3f6e; padding: 28px 32px; color: #ffffff; }
		.header-badge { display: inline-block; background: #0e8ce9; color: #ffffff; font-size: 11px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 4px; margin-bottom: 8px; }
		.content { padding: 32px; }
		.lead-row { margin-bottom: 12px; font-size: 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px; }
		.lead-label { font-weight: 700; color: #0f172a; width: 130px; display: inline-block; }
		.lead-val { color: #334155; }
		.message-box { background: #f8fafc; border-left: 4px solid #0e8ce9; padding: 14px 18px; margin: 20px 0; font-size: 14px; color: #1e293b; font-style: italic; }
		.footer { background: #f1f5f9; padding: 16px 32px; font-size: 12px; color: #64748b; text-align: center; }
	</style>
</head>
<body>
	<div class="wrapper">
		<div class="container">
			<div class="header">
				<span class="header-badge">New Inbound Inquiry</span>
				<h1 style="margin: 0; font-size: 20px; font-weight: 800;">Strategy Consultation Request: <?php echo esc_html( $name ); ?></h1>
			</div>
			<div class="content">
				<div class="lead-row"><span class="lead-label">Lead Name:</span> <span class="lead-val"><strong><?php echo esc_html( $name ); ?></strong></span></div>
				<div class="lead-row"><span class="lead-label">Work Email:</span> <span class="lead-val"><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></span></div>
				<div class="lead-row"><span class="lead-label">Phone:</span> <span class="lead-val"><?php echo esc_html( $phone ?: 'Not provided' ); ?></span></div>
				<div class="lead-row"><span class="lead-label">Company / URL:</span> <span class="lead-val"><?php echo esc_html( $company ?: 'Not provided' ); ?></span></div>
				<div class="lead-row"><span class="lead-label">Service Needed:</span> <span class="lead-val"><?php echo esc_html( $service ); ?></span></div>
				<div class="lead-row"><span class="lead-label">Budget Tier:</span> <span class="lead-val"><?php echo esc_html( $budget ?: 'Unspecified' ); ?></span></div>
				<div class="lead-row"><span class="lead-label">Webhook Status:</span> <span class="lead-val"><?php echo esc_html( $webhook_status ); ?></span></div>

				<div style="font-weight: 700; font-size: 13px; color: #0f172a; margin-top: 20px;">Project Details & Scope:</div>
				<div class="message-box">
					<?php echo nl2br( esc_html( $message ) ); ?>
				</div>

				<div style="text-align: center; margin-top: 24px;">
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=agency_enquiry' ) ); ?>" style="display: inline-block; background: #026fc7; color: #fff; text-decoration: none; font-weight: 700; font-size: 13px; padding: 10px 24px; border-radius: 6px;">View Enquiries in WordPress Dashboard →</a>
				</div>
			</div>
			<div class="footer">
				Received via <?php echo esc_html( $site_name ); ?> on <?php echo esc_html( current_time( 'F j, Y, g:i a' ) ); ?>
			</div>
		</div>
	</div>
</body>
</html>

