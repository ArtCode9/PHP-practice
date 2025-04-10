<div class="consultation-booking-form">
    <h2><?php _e('رزرو وقت مشاوره', 'consultation-booking'); ?></h2>
    
    <form id="booking-form">
        <div class="form-group">
            <label for="name"><?php _e('نام کامل:', 'consultation-booking'); ?></label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="email"><?php _e('ایمیل:', 'consultation-booking'); ?></label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="phone"><?php _e('شماره تلفن:', 'consultation-booking'); ?></label>
            <input type="tel" id="phone" name="phone" required>
        </div>
        
        <div class="form-group">
            <label for="consultant"><?php _e('انتخاب مشاور:', 'consultation-booking'); ?></label>
            <select id="consultant" name="consultant" required>
                <option value=""><?php _e('-- انتخاب کنید --', 'consultation-booking'); ?></option>
                <option value="1"><?php _e('مشاور اول', 'consultation-booking'); ?></option>
                <option value="2"><?php _e('مشاور دوم', 'consultation-booking'); ?></option>
                <option value="3"><?php _e('مشاور سوم', 'consultation-booking'); ?></option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="date"><?php _e('تاریخ:', 'consultation-booking'); ?></label>
            <input type="date" id="date" name="date" required>
        </div>
        
        <div class="form-group">
            <label for="time"><?php _e('ساعت:', 'consultation-booking'); ?></label>
            <input type="time" id="time" name="time" required>
        </div>
        
        <button type="submit"><?php _e('ثبت نوبت', 'consultation-booking'); ?></button>
        
        <div id="booking-response"></div>
    </form>
</div>