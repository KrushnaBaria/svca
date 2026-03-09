<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Invoice - <?php echo $invoiceNo ?? ''; ?></title>
        <style>
            body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; color: #333; }
            .container { width: 100%; padding: 10px 20px; }
            .header { border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 15px; }
            .header h2 { margin: 0; }
            .row { width: 100%; display: flex; justify-content: space-between; margin-bottom: 8px; }
            .col { width: 48%; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
            th { background: #f2f2f2; }
            .text-right { text-align: right; }
            .text-center { text-align: center; }
            .summary-table td { border: none; }
            .summary-table tr td:first-child { font-weight: bold; }
            .small { font-size: 11px; color: #666; }
        </style>
    </head>
    <body>
        <div class="container">
            <div style="text-align: center; margin-bottom: 15px;">
                <?php if($student['course_type'] == 'academy') { ?>
                    <h1 style="margin: 0; color: #333;">Swami Vivekanand Career Academy</h1>
                <?php } else { ?>
                    <h1 style="margin: 0; color: #333;">Swami Vivekanand Computer Class</h1>
                <?php } ?>
            </div>
            <div class="header">
                <h2>Fee Receipt</h2>
                <div class="small">
                    <strong>Receipt No:</strong> <?php echo $invoiceNo ?? ''; ?> &nbsp; | &nbsp;
                    <strong>Date:</strong> <?php echo $generatedAt ?? date('d/m/Y H:i'); ?>
                    <span style="float:right; top: 40px; position: absolute;">
                        <img src="<?php echo base_url('public/assets/images/logos/favicon.svg'); ?>" alt="Logo" style="height:70px;">
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h3 style="margin:0 0 6px 0;">Student Details</h3>
                    <table class="summary-table">
                        <tr>
                            <td>Name</td>
                            <td width="80%"><?php echo ($student['name'] ?? '') . ' ' . ($student['fname'] ?? ''); ?></td>
                        </tr>
                        <tr>
                            <td>Course</td>
                            <td><?php echo $student['course_name'] ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Center</td>
                            <td><?php echo $student['center_name'] ?? ''; ?></td>
                        </tr>
                        <tr>
                            <td>Admission Date</td>
                            <td><?php echo !empty($student['admi_date']) ? date('d/m/Y', strtotime($student['admi_date'])) : ''; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col">
                    <h3 style="margin:0 0 6px 0;">Fee Summary</h3>
                    <table>
                        <thead>
                            <tr>
                                <th style="width:50%;">Description</th>
                                <th style="width:50%; text-align:center;">Amount (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Fees</td>
                                <td class="text-center">₹<?php echo number_format($totalFees ?? 0, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Total Paid</td>
                                <td class="text-center">₹<?php echo number_format($paidAmount ?? 0, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Pending</td>
                                <td class="text-center">₹<?php echo number_format($pendingAmount ?? 0, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <h3 style="margin:15px 0 6px 0;">Payment History</h3>
            <table>
                <thead>
                <tr>
                    <th style="width:10%;" class="text-center">No</th>
                    <th style="width:15%;" class="text-center">Date</th>
                    <th style="width:25%;" class="text-center">Remark</th>
                    <th style="width:20%;" class="text-center">Amount (₹)</th>
                    <!-- <th style="width:25%;">Updated By</th> -->
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($payments)): ?>
                    <?php foreach ($payments as $p): ?>
                        <tr>
                            <td class="text-center"><?php echo $loop_index = isset($loop_index) ? $loop_index + 1 : 1; ?></td>
                            <td class="text-center"><?php echo !empty($p['add_date']) ? date('d/m/Y H:i', strtotime($p['add_date'])) : ''; ?></td>
                            <td><?php echo $p['remark'] ?? ''; ?></td>
                            <td class="text-center">₹<?php echo number_format((float)$p['amount'], 2); ?></td>
                            <!-- <td><?php echo $p['updated_by'] ?? ''; ?></td> -->
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No payment records found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <div style="margin-top:40px; text-align:right;">
                <p>
                    <strong>Authorized Signatory</strong>
                </p>
                <div style="height:50px;"></div>
                <p style="border-top: 1px solid #333; display:inline-block; padding-top:4px;">
                    Signature
                </p>
            </div>

            <!-- <p class="small" style="margin-top:20px;">
                This is a system generated invoice and does not require a physical signature.
            </p> -->
        </div>
            <div style="position: fixed; bottom: 1px; text-align: center; border-top: 1px solid #ccc; width:100%;">
                <p class="small">Generated Through Swami Vivekanand Career Academy Official Website On <?php echo date('d/m/Y, H:i:s'); ?></p>
            </div>
    </body>
</html>