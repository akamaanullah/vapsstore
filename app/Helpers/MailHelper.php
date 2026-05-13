<?php
namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class MailHelper {

    /**
     * Get a configured PHPMailer instance
     */
    public static function getMailer() {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'] ?? 'mail.theperfectvape.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USER'] ?? 'orders@theperfectvape.com';
            $mail->Password   = $_ENV['SMTP_PASS'] ?? 'ifYp*&FwZ,4%';
            $mail->SMTPSecure = $_ENV['SMTP_ENCRYPTION'] === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['SMTP_PORT'] ?? 465;

            // Default sender
            $fromEmail = $_ENV['SMTP_FROM_EMAIL'] ?? 'orders@theperfectvape.com';
            $fromName = $_ENV['SMTP_FROM_NAME'] ?? 'The Perfect Vape';
            $mail->setFrom($fromEmail, $fromName);

            return $mail;
        } catch (Exception $e) {
            error_log("Mailer setup failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get professional email layout
     */
    private static function getBaseTemplate($title, $content) {
        $logo = BASE_URL . '/admin_assets/image/theperfectvape.png';
        $primaryColor = '#bd0028';
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <style>
                body { font-family: 'Inter', 'Segoe UI', Helvetica, Arial, sans-serif; line-height: 1.6; color: #4a5568; margin: 0; padding: 0; background-color: #f7fafc; }
                .wrapper { width: 100%; table-layout: fixed; background-color: #f7fafc; padding: 40px 0; }
                .main { background-color: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-radius: 12px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); }
                .header { background-color: #ffffff; padding: 35px; text-align: center; border-bottom: 1px solid #edf2f7; }
                .content { padding: 40px; }
                .footer { text-align: center; padding: 30px; font-size: 13px; color: #a0aec0; background-color: #ffffff; border-top: 1px solid #edf2f7; }
                .btn { background-color: $primaryColor; color: #ffffff !important; padding: 14px 30px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block; margin-top: 25px; font-size: 15px; box-shadow: 0 4px 6px rgba(189, 0, 40, 0.25); }
                .item-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
                .item-table th { text-align: left; border-bottom: 1px solid #e2e8f0; padding: 12px 0; font-size: 12px; color: #718096; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; }
                .item-table td { padding: 18px 0; border-bottom: 1px solid #edf2f7; }
                .product-img { width: 56px; height: 56px; border-radius: 10px; object-fit: cover; border: 1px solid #edf2f7; margin-right: 16px; vertical-align: middle; }
                .product-name { font-weight: 700; color: #1a202c; font-size: 15px; }
                .price-txt { font-weight: 700; color: #2d3748; font-size: 15px; }
                .total-label { font-size: 14px; color: #718096; text-align: right; padding-top: 25px; }
                .total-amount { font-size: 24px; font-weight: 800; color: $primaryColor; text-align: right; padding-top: 5px; }
                h2 { font-size: 24px; font-weight: 800; color: #1a202c; letter-spacing: -0.02em; }
                p { font-size: 16px; color: #4a5568; }
            </style>
        </head>
        <body>
            <div class='wrapper'>
                <div class='main'>
                    <div class='header'>
                        <img src='$logo' alt='The Perfect Vape' style='width: 150px;'>
                    </div>
                    <div class='content'>
                        <h2 style='margin-top: 0; color: #1a1a1a;'>$title</h2>
                        $content
                    </div>
                </div>
                <div class='footer'>
                    &copy; " . date('Y') . " The Perfect Vape. All rights reserved.<br>
                    This is an automated message, please do not reply.
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Send Order Confirmation Email
     */
    public static function sendOrderConfirmation($order) {
        $mail = self::getMailer();
        if (!$mail) return false;

        try {
            $mail->addAddress($order['customer_email'], $order['customer_first_name']);
            $mail->isHTML(true);
            $mail->Subject = "Order Confirmation #{$order['order_number']}";

            $itemsHtml = "<table class='item-table'>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style='text-align: center;'>Qty</th>
                        <th style='text-align: right;'>Price</th>
                    </tr>
                </thead>
                <tbody>";

            foreach ($order['items'] as $item) {
                $imgUrl = $item['featured_image'];
                if ($imgUrl && !filter_var($imgUrl, FILTER_VALIDATE_URL)) {
                    $imgUrl = BASE_URL . '/' . ltrim($imgUrl, '/');
                }
                $displayImg = $imgUrl ?: BASE_URL . '/admin_assets/image/placeholder.png';

                $itemsHtml .= "
                <tr>
                    <td>
                        <img src='$displayImg' class='product-img' alt=''>
                        <span class='product-name'>{$item['product_name']}</span>
                    </td>
                    <td style='text-align: center; color: #718096;'>{$item['quantity']}</td>
                    <td style='text-align: right;' class='price-txt'>£" . number_format($item['price_at_purchase'], 2) . "</td>
                </tr>";
            }

            $itemsHtml .= "
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan='2' class='total-label'>Subtotal:</td>
                        <td style='text-align: right; padding-top: 25px; color: #4a5568;'>£" . number_format($order['total_amount'], 2) . "</td>
                    </tr>
                    <tr>
                        <td colspan='2' style='text-align: right; padding-top: 5px; font-weight: 700; color: #2d3748;'>Total:</td>
                        <td class='total-amount'>£" . number_format($order['total_amount'], 2) . "</td>
                    </tr>
                </tfoot>
            </table>";

            $content = "
                <p>Hi {$order['customer_first_name']},</p>
                <p>We've received your order #<strong>{$order['order_number']}</strong> and we're getting it ready to ship. We'll notify you as soon as it's on its way!</p>
                
                $itemsHtml
                
                <div style='text-align: center;'>
                    <a href='" . BASE_URL . "/order-status?order={$order['order_number']}&email={$order['customer_email']}' class='btn'>View Order Details</a>
                </div>";

            $mail->Body = self::getBaseTemplate("Thank you for your order!", $content);
            return $mail->send();
        } catch (Exception $e) {
            error_log("Order Confirmation Email failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Send Shipping Status Update Email
     */
    public static function sendShippingUpdate($order) {
        $mail = self::getMailer();
        if (!$mail) return false;

        try {
            $mail->addAddress($order['customer_email'], $order['customer_first_name']);
            $mail->isHTML(true);
            $mail->Subject = "Shipping Update for Order #{$order['order_number']}";

            $statusLabel = strtoupper($order['shipping_status']);
            
            $statusExtra = "";
            $shippingStatuses = ['shipped', 'in_transit', 'out_for_delivery', 'delivered'];
            if (in_array($order['shipping_status'], $shippingStatuses) && !empty($order['tracking_number'])) {
                $statusExtra = "
                <div style='background-color: #f8f8fb; border-radius: 8px; padding: 20px; margin-top: 20px; border: 1px dashed #e2e8f0; text-align: center;'>
                    <div style='font-size: 14px; color: #718096; margin-bottom: 5px;'>TRACKING NUMBER</div>
                    <div style='font-size: 20px; font-weight: bold; color: #1a1a1a; letter-spacing: 1px;'>{$order['tracking_number']}</div>
                </div>";
            }

            $content = "
                <p>Hi {$order['customer_first_name']},</p>
                <p>Great news! The status of your order #<strong>{$order['order_number']}</strong> has been updated to: <strong style='color: #6f6af8;'>$statusLabel</strong>.</p>
                
                $statusExtra
                
                <div style='text-align: center;'>
                    <a href='" . BASE_URL . "/order-status?order={$order['order_number']}&email={$order['customer_email']}' class='btn'>Track Your Package</a>
                </div>";

            $mail->Body = self::getBaseTemplate("Order Status Update", $content);
            $sent = $mail->send();
            if (!$sent) error_log("Mailer Error: " . $mail->ErrorInfo);
            return $sent;
        } catch (Exception $e) {
            error_log("Shipping Update Email failed: " . $e->getMessage());
            return false;
        }
    }
}
