<?php
/**
 * Admin Metaboxes for contact form.
 */

class HTD_Contact_Form_Admin_Metaboxes
{

    public function __construct()
    {

        add_action('add_meta_boxes', array($this, 'add_metaboxes'));
        add_action( 'admin_enqueue_scripts' , array($this, 'enqueue_scripts' ));

    }
    public function enqueue_scripts(){

        wp_enqueue_script( 'htd-contact-form-admin-js', HTD_CONTACT_FORM_PLUGIN_DIR . 'assets/admin/js/htd-contact-formp-admin-js.js', array( 'jquery', 'wp-util' ), '', true );

    }

    public function add_metaboxes()
    {

        add_meta_box('htd-contact-form-meta', __('Form Fields', 'htd-contact-form'), array($this, 'callback'), 'htd-contact-form', 'normal', 'high');
        add_meta_box('htd-contact-shortcode', __('Form Shortcode', 'htd-contact-form'), array($this, 'shortcode_callback'), 'htd-contact-form', 'side', 'high');
    }

    public function callback()
    {
        global $post;

        $field_types = array(
            'text' => __('Text', 'htd-contact-form'),
            'number' => __('Number', 'htd-contact-form'),
            'email' => __('Email', 'htd-contact-form'),
            'textarea' => __('Textarea', 'htd-conatct-form'),
            'date' => __('Date', 'htd-contact-form'),

        );

        ?>
        <div id="htd-form-field-wrap">
        <p class="form-group">
        <label for="field-name"><?php esc_html_e('Field Name', 'htd-contact-form');?></label>
        <input name="htd_cf_fields[][field_name]" required id="field-name" type="text" value="" class="widefat">
        </p>
        <p class="form-group">
        <label for="field-type"><?php esc_html_e('Field Type', 'htd-contact-form');?></label>
        <select name="htd_cf_fields[][field_type]" required name="" id="field-type" class="widefat">
        <option value=""><?php esc_html_e('Select', 'htd-contact-form'); ?></option>
        <?php foreach ($field_types as $k => $v): ?>
        <option value="<?php echo esc_attr($k); ?> "><?php echo esc_html($v); ?></option>

    <?php endforeach;?>

        </select>
        </p>

        <p class="form-group">
        <label for="field-placeholder"><?php esc_html_e('Placeholder', 'htd-contact-form');?></label>
        <input name="htd_cf_fields[][field_placeholder]" required id="field-placeholder" type="text" value="" class="widefat">
        </p>
        <p class="form-group">
        <label for="field-required"><?php esc_html_e('Required ?', 'htd-contact-form');?></label>
        <input name="htd_cf_fields[][field_required]" required id="field-required" type="checkbox" value="" class="widefat">
        </p>
        </div>

        <button id="add_field"><?php echo esc_html__( 'Add Field', 'htd-contact-form' ); ?></button>

        <script type="text/html" id="tmpl-htd-contact-form-field">
            
        <p class="form-group">
        <label for="field-name"><?php esc_html_e('Field Name', 'htd-contact-form');?></label>
        <input name="htd_cf_fields[][field_name]" required id="field-name" type="text" value="" class="widefat">
        </p>
        <p class="form-group">
        <label for="field-type"><?php esc_html_e('Field Type', 'htd-contact-form');?></label>
        <select name="htd_cf_fields[][field_type]" required name="" id="field-type" class="widefat">
        <option value=""><?php esc_html_e('Select', 'htd-contact-form');?></option>
        <?php foreach ($field_types as $k => $v): ?>
        <option value="<?php echo esc_attr($k); ?> "><?php echo esc_html($v); ?></option>

    <?php endforeach;?>

        </select>
        </p>

        <p class="form-group">
        <label for="field-placeholder"><?php esc_html_e('Placeholder', 'htd-contact-form'); ?></label>
        <input name="htd_cf_fields[][field_placeholder]" required id="field-placeholder" type="text" value="" class="widefat">
        </p>
        <p class="form-group">
        <label for="field-required"><?php esc_html_e('Required ?', 'htd-contact-form'); ?></label>
        <input name="htd_cf_fields[][field_required]" required id="field-required" type="checkbox" value="" class="widefat">
        </p>

        </script>

        <?php
}
    public function shortcode_callback()
    {
        global $post;
    }
}
    
new HTD_Contact_Form_Admin_Metaboxes();
