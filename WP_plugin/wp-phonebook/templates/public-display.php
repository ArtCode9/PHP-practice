<div class="wp-phonebook">
    <h2>Phone Book:</h2>
    
    <div class="phonebook-contacts">
        <?php if (!empty($contacts)): ?>
            <ul>
                <?php foreach ($contacts as $contact): ?>
                <li class="libox" 
                style="margin: 12px; 
                       padding:6px;
                       border: 2px solid #ccc;
                       background-color: #2271b1;
                       border-radius:9px;
                       box-shadow: -5px 7px 3px black;">
                    <strong><?php echo esc_html($contact->name); ?></strong>
                    <div><?php echo esc_html($contact->phone); ?></div>
                    <?php if (!empty($contact->email)): ?>
                    <div><a style="color: antiquewhite;" href="mailto:<?php echo esc_attr($contact->email); ?>"><?php echo esc_html($contact->email); ?></a></div>
                    <?php endif; ?>
                </li>
                <br>
                <?php endforeach; ?>
            </ul>
           
        <?php else: ?>
            <p>Not Contact Include</p>
        <?php endif; ?>
    </div>
</div>