// فایل script.js را به این صورت به‌روزرسانی کنید:
jQuery(document).ready(function($) {
    $('.print-btn').on('click', function(e) {
        e.preventDefault();
        var recordId = $(this).data('record-id');
        
        $.ajax({
            url: advancedFormData.ajaxurl,
            type: 'GET',
            data: {
                action: 'get_form_record',
                id: recordId,
                nonce: advancedFormData.nonce
            },
            success: function(response) {
                if (response.success) {
                    $('#print-id').text(response.data.id);
                    $('#print-name').text(response.data.full_name);
                    $('#print-email').text(response.data.email);
                    $('#print-phone').text(response.data.phone);
                    $('#print-date').text(response.data.created_at);
                    
                    var printWindow = window.open('', '_blank');
                    var printContent = $('#print-template').html();
                    
                    printWindow.document.write(`
                        <!DOCTYPE html>
                        <html dir="rtl">
                        <head>
                            <meta charset="UTF-8">
                            <title>پرینت اطلاعات کاربر</title>
                            <style>
                                body {
                                    font-family: Tahoma, Arial, sans-serif;
                                    line-height: 1.6;
                                    color: #333;
                                }
                                .print-header {
                                    text-align: center;
                                    margin-bottom: 20px;
                                    padding-bottom: 15px;
                                    border-bottom: 2px solid #333;
                                }
                                .print-table {
                                    width: 100%;
                                    border-collapse: collapse;
                                    margin: 20px 0;
                                }
                                .print-table th, 
                                .print-table td {
                                    padding: 10px 15px;
                                    border: 1px solid #ddd;
                                    text-align: right;
                                }
                                .print-table th {
                                    background-color: #f5f5f5;
                                    width: 30%;
                                }
                                .print-footer {
                                    margin-top: 30px;
                                    padding-top: 15px;
                                    border-top: 2px solid #333;
                                    text-align: left;
                                }
                            </style>
                        </head>
                        <body>
                            ${printContent}
                            <script>
                                setTimeout(function() {
                                    window.print();
                                    window.close();
                                }, 300);
                            <\/script>
                        </body>
                        </html>
                    `);
                    printWindow.document.close();
                } else {
                    alert('خطا در دریافت اطلاعات: ' + response.data);
                }
            },
            error: function() {
                alert('خطا در ارتباط با سرور');
            }
        });
    });
});