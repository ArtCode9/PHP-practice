<div class="wp-phonebook">
    <h2>Phone Book:</h2>
    
    <div class="phonebook-contacts">
        <?php if (!empty($contacts)): ?>
            <ul>
                <?php foreach ($contacts as $contact): ?>
                <li>
                    <strong><?php echo esc_html($contact->name); ?></strong>
                    <div><?php echo esc_html($contact->phone); ?></div>
                    <?php if (!empty($contact->email)): ?>
                    <div><a href="mailto:<?php echo esc_attr($contact->email); ?>"><?php echo esc_html($contact->email); ?></a></div>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Not Contact Include</p>
        <?php endif; ?>
    </div>
</div>