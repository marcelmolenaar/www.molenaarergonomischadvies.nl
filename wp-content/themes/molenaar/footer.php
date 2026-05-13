</main>

<footer class="site-footer">
    <div class="wrap grid">
        <div>
            <h3>Molenaar Ergonomisch Advies</h3>
            <p>Praktisch en onderbouwd advies voor een gezonde werkomgeving.</p>
        </div>
        <div>
            <h3>Contact</h3>
            <p>
                <a href="mailto:<?php echo esc_attr(MOLENAAR_CONTACT['email']); ?>"><?php echo esc_html(MOLENAAR_CONTACT['email']); ?></a><br>
                <a href="tel:<?php echo esc_attr(str_replace('-', '', MOLENAAR_CONTACT['phone'])); ?>"><?php echo esc_html(MOLENAAR_CONTACT['phone']); ?></a><br>
                <span>KVK <?php echo esc_html(MOLENAAR_CONTACT['kvk']); ?> · BTW <?php echo esc_html(MOLENAAR_CONTACT['btw']); ?></span>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
