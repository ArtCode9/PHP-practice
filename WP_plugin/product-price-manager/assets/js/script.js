jQuery(function($) {
    // انتخاب همه
    $('#ppm-select-all').change(function() {
        $('.ppm-product-check').prop('checked', this.checked);
    });

    // ذخیره تک محصول
    $('.ppm-save-single').click(function() {
        let productId = $(this).data('id');
        let $row = $(this).closest('tr');
        
        let regularPrice = $row.find('.ppm-regular-price').val();
        let salePrice = $row.find('.ppm-sale-price').val();

        $.ajax({
            url: ppm_ajax.ajaxurl,
            method: 'POST',
            data: {
                action: 'ppm_save_single',
                nonce: ppm_ajax.nonce,
                product_id: productId,
                regular: regularPrice,
                sale: salePrice
            },
            success: (res) => {
                if (res.success) {
                    alert(res.data.message);
                }
            }
        });
    });

    // حذف تک محصول
    $('.ppm-delete-single').click(function() {
        if (!confirm('آیا از حذف این محصول اطمینان دارید؟')) return;
        
        $.ajax({
            url: ppm_ajax.ajaxurl,
            method: 'POST',
            data: {
                action: 'ppm_bulk_delete',
                nonce: ppm_ajax.nonce,
                product_ids: [$(this).data('id')]
            },
            success: () => location.reload()
        });
    });

    // به‌روزرسانی دسته‌ای
    $('.ppm-bulk-update').click(function() {
        let updates = [];
        $('.ppm-product-check:checked').each(function() {
            let $row = $(this).closest('tr');
            updates.push({
                product_id: $row.find('.ppm-product-check').val(),
                regular: $row.find('.ppm-regular-price').val(),
                sale: $row.find('.ppm-sale-price').val()
            });
        });
        
        $.ajax({
            url: ppm_ajax.ajaxurl,
            method: 'POST',
            data: {
                action: 'ppm_bulk_update',
                nonce: ppm_ajax.nonce,
                prices: updates
            },
            success: (res) => {
                alert(res.data.message);
                location.reload();
            }
        });
    });

    // حذف دسته‌ای
    $('.ppm-bulk-delete').click(function() {
        let selected = $('.ppm-product-check:checked').map((i, el) => el.value).get();
        
        if (!selected.length || !confirm(ppm_ajax.confirm_delete)) return;
        
        $.ajax({
            url: ppm_ajax.ajaxurl,
            method: 'POST',
            data: {
                action: 'ppm_bulk_delete',
                nonce: ppm_ajax.nonce,
                product_ids: selected
            },
            success: () => location.reload()
        });
    });
});