<?php
/**
 * HTML Confirmation Email Template
 *
 * Variables passed in:
 * - $name
 * - $email
 * - $phone
 * - $company
 * - $service
 * - $budget
 * - $message
 * - $site_name
 * - $site_url
 * - $agency_phone
 * - $agency_email
 *
 * @package Agency_Site_Core
 */

if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Growth Consultation Confirmation</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #334155; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; background-color: #f8fafc; padding: 40px 16px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 20px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); }
        .header { background: linear-gradient(135deg, #0b0f19 0%, #082849 100%); padding: 36px 32px; text-align: left; }
        .brand-badge { display: inline-block; background: rgba(14, 140, 233, 0.2); border: 1px solid rgba(14, 140, 233, 0.4); color: #7cc7fb; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 4px 12px; border-radius: 9999px; margin-bottom: 14px; }
        .header-title { color: #ffffff; font-size: 24px; font-weight: 800; margin: 0; line-height: 1.25; }
        .content { padding: 36px 32px; }
        .greeting { font-size: 18px; font-weight: 700; color: #0f172a; margin-top: 0; margin-bottom: 12px; }
        .lead-text { font-size: 15px; line-height: 1.6; color: #475569; margin-bottom: 24px; }
        .summary-card { background-color: #f0f7ff; border: 1px solid #bae0fd; border-radius: 14px; padding: 20px 24px; margin-bottom: 28px; }
        .summary-title { font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; color: #0358a1; margin: 0 0 14px 0; border-bottom: 1px solid #bae0fd; padding-bottom: 8px; }
        .summary-row { margin-bottom: 8px; font-size: 14px; line-height: 1.5; }
        .summary-label { font-weight: 700; color: #0f172a; width: 140px; display: inline-block; }
        .summary-val { color: #1e293b; }
        .timeline { margin: 28px 0; }
        .timeline-step { display: table; width: 100%; margin-bottom: 16px; }
        .timeline-num { display: table-cell; width: 28px; height: 28px; background-color: #0e8ce9; color: #ffffff; border-radius: 50%; text-align: center; vertical-align: middle; font-size: 12px; font-weight: 800; }
        .timeline-body { display: table-cell; padding-left: 14px; vertical-align: top; }
        .timeline-heading { font-size: 14px; font-weight: 700; color: #0f172a; margin: 0 0 3px 0; }
        .timeline-desc { font-size: 13px; color: #64748b; margin: 0; line-height: 1.4; }
        .btn { display: inline-block; background-color: #026fc7; color: #ffffff !important; text-decoration: none; font-size: 14px; font-weight: 700; padding: 13px 28px; border-radius: 9999px; text-align: center; }
        .footer { background-color: #0b0f19; padding: 28px 32px; text-align: center; color: #94a3b8; font-size: 12px; line-height: 1.6; }
        .footer a { color: #38a9f7; text-decoration: none; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Branded Header -->
            <div class="header">
                <span class="brand-badge">Inbound Consultation</span>
                <h1 class="header-title">We’ve Received Your Strategy Request</h1>
            </div>

            <!-- Email Body -->
            <div class="content">
                <h2 class="greeting">Hi <?php echo esc_html($name); ?>,</h2>
                <p class="lead-text">
                    Thank you for reaching out to <strong><?php echo esc_html($site_name); ?></strong>. We have securely logged your consultation request. A Senior Growth Architect is currently examining your brand’s search footprint and market opportunity.
                </p>

                <!-- Consultation Details Card -->
                <div class="summary-card">
                    <div class="summary-title">Your Inquiry Summary</div>
                    <div class="summary-row">
                        <span class="summary-label">Capability:</span>
                        <span class="summary-val"><strong><?php echo esc_html($service); ?></strong></span>
                    </div>
                    <?php if (!empty($budget)) : ?>
                    <div class="summary-row">
                        <span class="summary-label">Budget Tier:</span>
                        <span class="summary-val"><?php echo esc_html($budget); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($company)) : ?>
                    <div class="summary-row">
                        <span class="summary-label">Company / URL:</span>
                        <span class="summary-val"><?php echo esc_html($company); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($phone)) : ?>
                    <div class="summary-row">
                        <span class="summary-label">Direct Phone:</span>
                        <span class="summary-val"><?php echo esc_html($phone); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="summary-row" style="margin-top: 12px; padding-top: 10px; border-top: 1px dashed #bae0fd;">
                        <span class="summary-label" style="display: block; width: 100%; margin-bottom: 4px;">Project Scope / Notes:</span>
                        <span class="summary-val" style="color: #475569; font-style: italic; display: block;"><?php echo nl2br(esc_html($message)); ?></span>
                    </div>
                </div>

                <!-- 24-Hour Timeline -->
                <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-top: 24px; margin-bottom: 16px;">What Happens Over The Next 24 Hours:</h3>
                <div class="timeline">
                    <div class="timeline-step">
                        <div class="timeline-num">1</div>
                        <div class="timeline-body">
                            <div class="timeline-heading">Data & Competitor Footprint Scan</div>
                            <div class="timeline-desc">We run an initial audit of your organic authority, search keyword gaps, and competitor advertising hooks.</div>
                        </div>
                    </div>
                    <div class="timeline-step">
                        <div class="timeline-num">2</div>
                        <div class="timeline-body">
                            <div class="timeline-heading">Direct Strategist Outreach</div>
                            <div class="timeline-desc">Our Lead Growth Architect will contact you directly via email to coordinate a 30-minute discovery session.</div>
                        </div>
                    </div>
                    <div class="timeline-step">
                        <div class="timeline-num">3</div>
                        <div class="timeline-body">
                            <div class="timeline-heading">Tailored Growth Architecture Plan</div>
                            <div class="timeline-desc">We present transparent sprints, expected KPIs, and customized investment tiers built for your exact unit economics.</div>
                        </div>
                    </div>
                </div>

                <div style="text-align: center; margin: 32px 0 16px 0;">
                    <a href="<?php echo esc_url($site_url); ?>/services/" class="btn">Explore Our Service Playbooks →</a>
                </div>

                <p style="font-size: 13px; color: #94a3b8; text-align: center; margin-top: 24px;">
                    Need immediate assistance? Call us directly at <a href="tel:<?php echo esc_attr($agency_phone); ?>" style="color: #0e8ce9; font-weight: 600; text-decoration: none;"><?php echo esc_html($agency_phone); ?></a>
                </p>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p style="margin: 0 0 6px 0; font-weight: 700; color: #f1f5f9;"><?php echo esc_html($site_name); ?> — Digital Growth Agency</p>
                <p style="margin: 0 0 10px 0;">100 Innovation Blvd, Suite 400, San Francisco, CA 94105</p>
                <p style="margin: 0; color: #64748b;">
                    Sent securely from <a href="<?php echo esc_url($site_url); ?>"><?php echo esc_html(str_replace(['https://', 'http://'], '', untrailingslashit($site_url))); ?></a>. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>

