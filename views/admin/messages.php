<?php 
$pageTitle = "Messages | Vape Store Admin";
$pageScript = "messages.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container">
    <h1>Messages</h1>
    
    <div class="header-actions">
        <div class="search-container">
            <input type="text" placeholder="Search messages..." class="search-input">
        </div>
        <div class="per-page-container">
            <span class="text-label">Rows:</span>
            <select class="per-page-select">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>
</div>

<div class="card card-no-padding">
    <div class="table-responsive">
        <table class="product-table">
            <thead>
                <tr>
                    <th class="th-product">Customer</th>
                    <th class="th-default">Subject</th>
                    <th class="th-default">Message</th>
                    <th class="th-default">Date</th>
                    <th class="th-action text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sampleMessages = [
                    ['name' => 'Arsalan Khan', 'email' => 'arsalan@example.com', 'subject' => 'Wholesale Inquiry', 'message' => 'I am interested in buying vapes in bulk for my shop in Karachi...', 'date' => 'Oct 24, 2023', 'avatar' => 'AK'],
                    ['name' => 'Sara Malik', 'email' => 'sara.m@email.com', 'subject' => 'Order Tracking', 'message' => 'My order #7721 hasn\'t arrived yet. Can you please check the status?', 'date' => 'Oct 23, 2023', 'avatar' => 'SM'],
                    ['name' => 'Fahad Zaki', 'email' => 'fahad.zaki@domain.com', 'subject' => 'Product Warranty', 'message' => 'The Vaporesso device I bought last week stopped charging...', 'date' => 'Oct 22, 2023', 'avatar' => 'FZ'],
                    ['name' => 'John Doe', 'email' => 'john.d@gmail.com', 'subject' => 'Shipping Cost', 'message' => 'Do you ship to Lahore and what are the charges?', 'date' => 'Oct 21, 2023', 'avatar' => 'JD'],
                    ['name' => 'Zeeshan Ahmed', 'email' => 'zeeshan.a@yahoo.com', 'subject' => 'Nicotine Strength', 'message' => 'Do you have 50mg salt nicotine liquids available in stock?', 'date' => 'Oct 20, 2023', 'avatar' => 'ZA'],
                    ['name' => 'Bilal Sheikh', 'email' => 'bilal.s@outlook.com', 'subject' => 'Payment Issue', 'message' => 'My transaction failed but the amount was deducted from my bank.', 'date' => 'Oct 19, 2023', 'avatar' => 'BS'],
                    ['name' => 'Hamza Ali', 'email' => 'hamza.ali@gmail.com', 'subject' => 'New Arrival Inquiry', 'message' => 'When will the new Geek Bar Pulse variants be available?', 'date' => 'Oct 18, 2023', 'avatar' => 'HA'],
                    ['name' => 'Ayesha Khan', 'email' => 'ayesha.k@email.com', 'subject' => 'Refund Request', 'message' => 'I received a damaged product and want to initiate a refund.', 'date' => 'Oct 17, 2023', 'avatar' => 'AK'],
                    ['name' => 'Umer Farooq', 'email' => 'umer.f@domain.pk', 'subject' => 'Store Location', 'message' => 'Do you have any physical outlet in Islamabad for pickup?', 'date' => 'Oct 16, 2023', 'avatar' => 'UF'],
                    ['name' => 'Raza Shah', 'email' => 'raza.shah@live.com', 'subject' => 'Coil Compatibility', 'message' => 'Which coils are compatible with the Smok Novo 5 pod kit?', 'date' => 'Oct 15, 2023', 'avatar' => 'RS'],
                    ['name' => 'Madiha Noor', 'email' => 'madiha.n@gmail.com', 'subject' => 'Order Cancellation', 'message' => 'I want to cancel my order #9921 as I ordered the wrong flavor.', 'date' => 'Oct 14, 2023', 'avatar' => 'MN'],
                    ['name' => 'Kashif Ali', 'email' => 'kashif.a@email.com', 'subject' => 'Discount Codes', 'message' => 'Are there any active promo codes for first-time buyers?', 'date' => 'Oct 13, 2023', 'avatar' => 'KA'],
                    ['name' => 'Sania Mirza', 'email' => 'sania.m@yahoo.com', 'subject' => 'Battery Safety', 'message' => 'Which 18650 batteries do you recommend for high-wattage mods?', 'date' => 'Oct 12, 2023', 'avatar' => 'SM'],
                    ['name' => 'Osama Bin', 'email' => 'osama.b@gmail.com', 'subject' => 'Wholesale Prices', 'message' => 'Can you send me the wholesale price list for E-Liquids?', 'date' => 'Oct 11, 2023', 'avatar' => 'OB'],
                    ['name' => 'Zoya Khan', 'email' => 'zoya.k@domain.com', 'subject' => 'Flavor Request', 'message' => 'Please bring back the Mango Ice flavor in the 30ml salt nic.', 'date' => 'Oct 10, 2023', 'avatar' => 'ZK'],
                    ['name' => 'Imran Abbas', 'email' => 'imran.a@email.com', 'subject' => 'Technical Support', 'message' => 'My device screen is flickering. Is this covered under warranty?', 'date' => 'Oct 09, 2023', 'avatar' => 'IA'],
                ];
                
                foreach ($sampleMessages as $msg): ?>
                <tr>
                    <td class="td-product">
                        <div class="customer-info-cell">
                            <div class="avatar-sm"><?php echo $msg['avatar']; ?></div>
                            <div>
                                <p class="fw-600 m-0"><?php echo $msg['name']; ?></p>
                                <p class="text-muted-xs m-0"><?php echo $msg['email']; ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="td-default"><span class="fw-600"><?php echo $msg['subject']; ?></span></td>
                    <td class="td-default text-muted">
                        <p class="text-truncate-sm m-0"><?php echo $msg['message']; ?></p>
                    </td>
                    <td class="td-default text-muted"><?php echo $msg['date']; ?></td>
                    <td class="td-action">
                        <div class="action-flex">
                            <button class="btn-action-icon view-message-btn" 
                                    title="View Message"
                                    data-name="<?php echo $msg['name']; ?>"
                                    data-email="<?php echo $msg['email']; ?>"
                                    data-subject="<?php echo $msg['subject']; ?>"
                                    data-message="<?php echo $msg['message']; ?>"
                                    data-date="<?php echo $msg['date']; ?>"
                                    data-avatar="<?php echo $msg['avatar']; ?>">
                                <i data-lucide="eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="pagination-container">
        <div class="pagination-info">
            Showing <span>1</span> to <span>10</span> of <span>16</span> entries
        </div>
        <ul class="pagination">
            <li class="disabled"><a href="#">&laquo;</a></li>
            <li class="active"><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">&raquo;</a></li>
        </ul>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>

<!-- Message Detail Modal -->
<div class="modal-overlay" id="messageModal" style="display: none;">
    <div class="modal-content-sm" style="width: 550px;">
        <div class="modal-header">
            <h3>Message Detail</h3>
            <button class="close-modal-btn" id="closeModal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="customer-info-cell mb-20">
                <div class="avatar-sm" id="modalAvatar">AK</div>
                <div>
                    <p class="fw-700 m-0" id="modalName" style="font-size: 16px; color: var(--text-dark);">Arsalan Khan</p>
                    <p class="text-muted m-0" id="modalEmail" style="font-size: 13px;">arsalan@example.com</p>
                    <p class="text-muted m-0" id="modalDate" style="font-size: 11px; margin-top: 2px; font-weight: 500;">Oct 24, 2023</p>
                </div>
            </div>
            
            <div class="message-content-box">
                <div class="mb-15">
                    <label class="text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Subject</label>
                    <p class="fw-700 m-0" id="modalSubject" style="font-size: 15px; color: var(--text-dark);">Wholesale Inquiry</p>
                </div>
                
                <div class="mb-15">
                    <label class="text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Message</label>
                    <div style="background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid var(--border-color); line-height: 1.6; font-size: 13px; color: #475569;" id="modalMessage">
                        I am interested in buying vapes in bulk for my shop in Karachi...
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" id="closeModalBtn" style="width: 100px;">Close</button>
        </div>
    </div>
</div>

