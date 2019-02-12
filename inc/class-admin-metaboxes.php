<?php
/**
 * Admin Metaboxes for contact form.
 */

class HTD_Contact_Form_Admin_Metaboxes
{

    public function __construct()
    {

        add_action('add_meta_boxes', array($this, 'add_metaboxes'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action( 'save_post', array($this, 'save_data' ), 10, 2 );
    }
    public function enqueue_scripts()
    {

        wp_enqueue_script('htd-contact-form-admin-js', HTD_CONTACT_FORM_PLUGIN_DIR . 'assets/admin/js/htd-contact-formp-admin-js.js', array( 'jquery', 'wp-util', 'jquery-ui-sortable' ), '', true);

    }

    public function add_metaboxes()
    {

        add_meta_box('htd-contact-form-meta', __('Form Fields', 'htd-contact-form'), array($this, 'callback'), 'htd-contact-form', 'normal', 'high');
        add_meta_box('htd-contact-shortcode', __('Form Shortcode', 'htd-contact-form'), array($this, 'shortcode_callback'), 'htd-contact-form', 'side', 'high');
    }

    public function callback()
    {
        global $post;
        $post_id = $post->ID;

        $field_types = array(
            'text' => __('Text', 'htd-contact-form'),
            'number' => __('Number', 'htd-contact-form'),
            'email' => __('Email', 'htd-contact-form'),
            'textarea' => __('Textarea', 'htd-conatct-form'),
            'date' => __('Date', 'htd-contact-form'),

        );

        wp_nonce_field( 'htd_cf_save_fields_action', 'htd_cf_save_fields' );
        $formdata = get_post_meta( $post_id, 'htd_cf_fields', true );
        // echo ("<pre>");
        // print_r($formdata); 
        // echo ("</pre>");

        ?> 
        
            <div id="htd-form-field-wrap">
        

            <?php if( ! empty( $formdata ) && is_array( $formdata ) ) :
                
                foreach( $formdata as $key => $data ) :

                    $required =isset( $data['field_required'] ) ? $data['field_required'] : 'no';
                ?>
            
            <div class="f-options-group">

            <button  class="remove-group button-secondary button-large" ><?php echo esc_html__('Remove Field', 'htd-contact-form'); ?></button>   
            <p class="form-group">
            <label for="field-name"><?php esc_html_e('Field Name', 'htd-contact-form');?></label>
            <input name="htd_cf_fields[<?php echo esc_attr( $key ); ?>][field_name]" required id="field-name" type="text" value="<?php echo esc_attr( $data['field_name'] ); ?>" class="widefat">
            </p>
            <p class="form-group">
            <label for="field-type"><?php esc_html_e('Field Type', 'htd-contact-form');?></label>
            <select name="htd_cf_fields[<?php echo esc_attr( $key ); ?>][field_type]" required name="" id="field-type" class="widefat">
            <option value=""><?php esc_html_e('Select', 'htd-contact-form');?></option>
            <?php foreach ($field_types as $k => $v): ?>
                    <option  <?php selected( $data['field_type'], $k); ?> value="<?php echo esc_attr( $k ); ?>"> <?php echo esc_html( $v ); ?> </option>
        <?php endforeach; ?>
            </select>
            </p>

            <p class="form-group">
            <label for="field-placeholder"><?php esc_html_e('Placeholder', 'htd-contact-form');?></label>
            <input name="htd_cf_fields[<?php echo esc_attr( $key ); ?>][field_placeholder]" required id="field-placeholder" type="text" value="<?php echo esc_attr( $data['field_placeholder'] ); ?>" class="widefat">
            </p>
            <p class="form-group">
            <label for="field-required"><?php esc_html_e('Required ?', 'htd-contact-form'); ?></label>
            <input <?php checked( $required, 'yes'); ?> name="htd_cf_fields[<?php echo esc_attr( $key ); ?>][field_required]"  id="field-required" type="checkbox" value="yes"  >
            </p>
            </div>
            <?php 
            endforeach;
        endif; ?>
            </div>
            
            <button id="add_field" class="button button-primary button-large" ><?php echo esc_html__('Add Field', 'htd-contact-form'); ?></button>

                <!-- Script -->

            <script type="text/html" id="tmpl-htd-contact-form-field">
            
            <div class="f-options-group">

            <!-- <span class="remove-group">X</span> -->
            <button  class="remove-group button-secondary button-large" ><?php echo esc_html__('Remove Field', 'htd-contact-form'); ?></button>

            <p class="form-group">
            <label for="field-name"><?php esc_html_e('Field Name', 'htd-contact-form');?></label>
            <input name="htd_cf_fields[{{data.random}}][field_name]" required id="field-name" type="text" value="" class="widefat">
            </p>
            <p class="form-group">
            <label for="field-type"><?php esc_html_e('Field Type', 'htd-contact-form');?></label>
            <select name="htd_cf_fields[{{data.random}}][field_type]" required id="field-type" class="widefat">
            <option value=""><?php esc_html_e('Select', 'htd-contact-form');?></option>
            <?php foreach ($field_types as $k => $v): ?>
            <option value="<?php echo esc_attr($k); ?> "><?php echo esc_html($v); ?></option>

        <?php endforeach;?>

            </select>
            </p>

            <p class="form-group">
            <label for="field-placeholder"><?php esc_html_e('Placeholder', 'htd-contact-form');?></label>
            <input name="htd_cf_fields[{{data.random}}][field_placeholder]" required id="field-placeholder" type="text" value="" class="widefat">
            </p>
            <p class="form-group">
            <label for="field-required"><?php esc_html_e('Required ?', 'htd-contact-form');?></label>
            <input  name="htd_cf_fields[{{data.random}}][field_required]"  id="field-required" type="checkbox" value="yes" class="widefat">
            </p>
            </div>
            </script>

            <?php
}
    public function shortcode_callback()
    {
        global $post;
        $post_id = $post->ID;
        ?>
        <span class="shortcode_info"><?php esc_html_e( 'use the shortcode below to print form in posts and page:', 'htd-contact-form') ?></span>
        <input type="text" class="widefat" readonly value="[HTD_CF form_id='<?php echo esc_attr( $post_id ); ?>']"  >
    <?php 
    }

    public function save_data( $post_id, $post ){

        // add nonce for security and authentication

        $nonce_name = isset( $_POST['htd_cf_save_fields'] ) ? $_POST['htd_cf_save_fields'] : '';
        $nonce_action = 'htd_cf_save_fields_action';

        //check if nonce is set.

        if( ! isset( $nonce_name ) ){

            return;
        }

        //check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ){
            return;
        }

        //check if user has permission to save data.

        if ( ! current_user_can( 'edit_post', $post_id ) ){
            return;
        }

        //check if not an autosave.

        if ( wp_is_post_autosave( $post_id ) ){
            return;
        }

        //check if not a revision.

        if ( wp_is_post_revision( $post_id ) ){
            return;
        }


    if ( isset( $_POST['htd_cf_fields']) && ! empty( $_POST['htd_cf_fields'] ) ): 
    
        $formdata = stripslashes_deep( $_POST['htd_cf_fields'] );

        update_post_meta( $post_id , 'htd_cf_fields', $formdata);

    endif;

    }

}


new HTD_Contact_Form_Admin_Metaboxes();
