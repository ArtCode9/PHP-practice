jQuery(document).ready(function($) {
    // شمارنده برای آیتم‌های دینامیک
    let educationCounter = 1;
    let certificateCounter = 1;
    
    // افزودن مدرک تحصیلی جدید
    $('#add-education').on('click', function() {
        const newItem = `
            <div class="education-item">
                <div class="form-row">
                    <div class="form-group">
                        <select name="education[${educationCounter}][degree]">
                            <option value="">انتخاب کنید</option>
                            <option value="diploma">دیپلم</option>
                            <option value="bachelor">لیسانس</option>
                            <option value="master">فوق لیسانس</option>
                            <option value="phd">دکترا</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="education[${educationCounter}][major]" placeholder="مثال: زبان انگلیسی">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" name="education[${educationCounter}][institution]" placeholder="نام مؤسسه آموزشی">
                    </div>
                    
                    <div class="form-group">
                        <input type="number" name="education[${educationCounter}][year]" placeholder="1400" min="1300" max="1405">
                    </div>
                </div>
                <button type="button" class="remove-btn remove-education">حذف این مدرک</button>
            </div>
        `;
        
        $('#education-items').append(newItem);
        educationCounter++;
    });
    
    // افزودن مدرک زبان جدید
    $('#add-certificate').on('click', function() {
        const newItem = `
            <div class="certificate-item">
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" name="certificates[${certificateCounter}][type]" placeholder="مثال: آیلتس، تافل">
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="certificates[${certificateCounter}][score]" placeholder="مثال: 7.5، Advanced">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <input type="date" name="certificates[${certificateCounter}][date]">
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="certificates[${certificateCounter}][institution]">
                    </div>
                </div>
                <button type="button" class="remove-btn remove-certificate">حذف این مدرک</button>
            </div>
        `;
        
        $('#certificate-items').append(newItem);
        certificateCounter++;
    });
    
    // حذف آیتم‌ها
    $(document).on('click', '.remove-education, .remove-certificate', function() {
        $(this).parent().remove();
    });
    
    // اعتبارسنجی فرم
    $('#teacher-application').on('submit', function(e) {
        let isValid = true;
        const requiredFields = $(this).find('[required]');
        
        requiredFields.each(function() {
            if (!$(this).val()) {
                $(this).addClass('field-error');
                isValid = false;
            } else {
                $(this).removeClass('field-error');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('.field-error').first().offset().top - 100
            }, 500);
            
            alert('لطفا تمام فیلدهای اجباری را پر کنید.');
        }
    });
    
    // اعتبارسنجی کد ملی
    $('#national_id').on('blur', function() {
        const nationalId = $(this).val();
        if (nationalId.length === 10 && !/^\d{10}$/.test(nationalId)) {
            alert('کد ملی باید 10 رقم عددی باشد');
            $(this).val('');
        }
    });
});



// اضافه کردن این تابع به فایل script.js
jQuery(document).ready(function($) {
    // تابع پرینت برای هر درخواست
    function printSingleApplication(applicationId) {
        $.ajax({
            url: teacherApplicationData.ajaxurl,
            type: 'GET',
            data: {
                action: 'get_teacher_application',
                id: applicationId,
                nonce: teacherApplicationData.nonce
            },
            success: function(response) {
                if (response.success) {
                    openPrintWindow(response.data);
                } else {
                    alert('خطا در دریافت اطلاعات: ' + response.data);
                }
            },
            error: function() {
                alert('خطا در ارتباط با سرور');
            }
        });
    }

    // نمایش پنجره پرینت
    function openPrintWindow(application) {
        var printWindow = window.open('', '_blank');
        var printContent = `
            <!DOCTYPE html>
            <html dir="rtl">
            <head>
                <meta charset="UTF-8">
                <title>پرینت درخواست استخدام - ${application.full_name}</title>
                <style>
                    body {
                        font-family: Tahoma, Arial, sans-serif;
                        line-height: 1.6;
                        padding: 20px;
                        color: #333;
                    }
                    .print-header {
                        text-align: center;
                        margin-bottom: 30px;
                        padding-bottom: 15px;
                        border-bottom: 2px solid #333;
                    }
                    .print-header h1 {
                        color: #2c3e50;
                        margin-bottom: 10px;
                    }
                    .detail-table {
                        width: 100%;
                        border-collapse: collapse;
                        margin: 20px 0;
                    }
                    .detail-table th, .detail-table td {
                        padding: 12px;
                        border: 1px solid #ddd;
                        text-align: right;
                    }
                    .detail-table th {
                        background-color: #f5f5f5;
                        width: 30%;
                    }
                    .section-title {
                        color: #3498db;
                        margin: 30px 0 15px;
                        padding-bottom: 5px;
                        border-bottom: 1px solid #eee;
                    }
                    .print-footer {
                        margin-top: 50px;
                        padding-top: 15px;
                        border-top: 1px solid #333;
                    }
                </style>
            </head>
            <body>
                <div class="print-header">
                    <h1>گزارش درخواست استخدام مدرس</h1>
                    <p>تاریخ چاپ: ${new Date().toLocaleDateString('fa-IR')}</p>
                </div>

                <h3 class="section-title">اطلاعات شخصی</h3>
                <table class="detail-table">
                    <tr>
                        <th>نام کامل:</th>
                        <td>${application.full_name}</td>
                    </tr>
                    <tr>
                        <th>کد ملی:</th>
                        <td>${application.national_id || '---'}</td>
                    </tr>
                    <tr>
                        <th>تلفن همراه:</th>
                        <td>${application.mobile}</td>
                    </tr>
                    <tr>
                        <th>ایمیل:</th>
                        <td>${application.email}</td>
                    </tr>
                    <tr>
                        <th>تاریخ ثبت درخواست:</th>
                        <td>${application.application_date}</td>
                    </tr>
                </table>

                <h3 class="section-title">زبان‌ها و گروه‌های سنی</h3>
                ${renderLanguagesTable(application.languages)}

                <h3 class="section-title">سوابق تحصیلی</h3>
                ${renderEducationTable(application.education)}

                <div class="print-footer">
                    <p>امضاء مسئول: ________________________</p>
                    <p style="text-align: center; font-size: 12px; color: #777;">
                        این سند به صورت خودکار تولید شده است
                    </p>
                </div>

                <script>
                    setTimeout(function() {
                        window.print();
                        window.close();
                    }, 500);
                <\/script>
            </body>
            </html>
        `;

        printWindow.document.write(printContent);
        printWindow.document.close();
    }

    // تولید جدول زبان‌ها
    function renderLanguagesTable(languages) {
        if (!languages || languages.length === 0) {
            return '<p>هیچ زبانی انتخاب نشده است</p>';
        }

        let html = '<table class="detail-table"><tr><th>زبان</th><th>7-12 سال</th><th>نوجوانان</th><th>بزرگسالان</th></tr>';
        
        languages.forEach(lang => {
            html += `
                <tr>
                    <td>${lang.name}</td>
                    <td>${lang.age_7_12 ? '✓' : '✗'}</td>
                    <td>${lang.teenagers ? '✓' : '✗'}</td>
                    <td>${lang.adults ? '✓' : '✗'}</td>
                </tr>
            `;
        });

        html += '</table>';
        return html;
    }

    // تولید جدول تحصیلات
    function renderEducationTable(education) {
        if (!education || education.length === 0) {
            return '<p>هیچ مدرک تحصیلی ثبت نشده است</p>';
        }

        let html = '<table class="detail-table"><tr><th>مدرک</th><th>رشته</th><th>مرکز آموزشی</th><th>سال فراغت</th></tr>';
        
        education.forEach(edu => {
            html += `
                <tr>
                    <td>${getDegreeName(edu.degree)}</td>
                    <td>${edu.major || '---'}</td>
                    <td>${edu.institution || '---'}</td>
                    <td>${edu.year || '---'}</td>
                </tr>
            `;
        });

        html += '</table>';
        return html;
    }

    // تبدیل نام مدرک
    function getDegreeName(degree) {
        const degrees = {
            'diploma': 'دیپلم',
            'bachelor': 'لیسانس',
            'master': 'فوق لیسانس',
            'phd': 'دکترا'
        };
        return degrees[degree] || degree;
    }

    // رویداد کلیک برای دکمه‌های پرینت
    $(document).on('click', '.print-application-btn', function(e) {
        e.preventDefault();
        var applicationId = $(this).data('id');
        printSingleApplication(applicationId);
    });

    // مقداردهی اولیه متغیرهای جاوااسکریپت
    var teacherApplicationData = {
        ajaxurl: '<?php echo admin_url("admin-ajax.php"); ?>',
        nonce: '<?php echo wp_create_nonce("teacher_application_nonce"); ?>'
    };
});