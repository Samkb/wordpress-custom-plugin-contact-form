<?php
/**
 * Register and handle shortcode output.
 */

class HTD_Contact_Form_Shortcode {

    public function __construct()
    {
        add_action('init', array($this, 'register_shortcode' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' )  );
    }

    public function register_shortcode()
    {

        add_shortcode('HTD_CF', array( $this, 'shortcode_output' ) );

    }

    public function enqueue_scripts(){

        wp_enqueue_script( 'htd-cf-frontend-script', HTD_CONTACT_FORM_PLUGIN_DIR . '/assets/public/js/htd-contact-form-frontend-js.js', array( 'jquery', 'jquery-ui-datepicker' ),'', true );
        wp_enqueue_script( 'parsley-js', 'https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.8.1/parsley.min.js', array( 'jquery' ), '2.8.1', true );

    }

    public function shortcode_output($atts)
    {

        // var_dump($atts);
        // die;

        $post_id = isset( $atts['form_id'] ) ? $atts['form_id'] : false;

        if ( ! $post_id) 
            return;
        
        $formdata = get_post_meta( $post_id, 'htd_cf_fields', true );
        $form_title = $this->slugify( get_the_title( $post_id ) );

        ob_start();

        if ( empty( $formdata ) ) {

            echo '<span class="thd-cf-error">' . esc_html__('Selected Form Contains no Fields.  Please add Some form fields First', 'htd-conact-form') . '</span>';
            $data = ob_get_clean();
            return $data;

        }

            ?>

                <form data-parsley-validate class="htd-frontend-form" id="<?php echo esc_attr( $form_title . '_' . $post_id ); ?>" action="" method="post">
                <input type="hidden" name="<?php echo esc_attr( $form_title . '[form_id]');?>" value="<?php echo esc_attr( $post_id ); ?>" >
                <?php  wp_nonce_field( $form_title . '_' . $post_id . 'front_end_fields_action', $form_title . '_' . $post_id . 'front_end_fields' ); ?>
                <?php foreach( $formdata as $key => $field ) : 
                    $field['name_slug'] = $form_title;

                        $this->render_field( $field );
                endforeach;  ?>  
            <input type="submit" class="htd-cf-frontend-submit" value="<?php echo esc_attr( 'Submit' , 'htd-contact-form'  ) ?>" >
            
                </form>

            <?php

        $data = ob_get_clean();
        return $data;
}
    public function render_field( $field = false ) {

        if ( ! $field )  
            return; 

        $field_type = $field['field_type'];
        $name_slug = $field['name_slug'];

        // var_dump( $field_type );


        //vars
        $name = isset( $field['field_name'] ) ? $this->slugify( $field['field_name'] ) : '';
        $name = $name_slug . '[' . $name . ']';
        $id = isset( $field['field_name'] ) ? $this->slugify( $field['field_name'] )  : '';
        $placeholder = isset( $field['field_placeholder'] ) ? $field['field_placeholder'] : '';
        $required = isset( $field['field_required'] ) ? 'required' : '';

        switch ($field_type) {

            case "text":
                echo "<input type='text' class='form-control' name='" . esc_attr( $name ) . " ' value='' id='" . esc_attr( $id ) . " ' placeholder='" . esc_attr( $placeholder ) . "' " . $required . " ></br>";
                break; 
            case "number";
                echo "<input type='number' class='form-control' name='" . esc_attr( $name ) . " ' value='' id='" . esc_attr( $id ) . " ' placeholder='" . esc_attr( $placeholder ) . "' " . $required . " ></br>";
                break;
            case "email";
                echo "<input type='email' class='form-control' name='" . esc_attr( $name ) . " ' value='' id='" . esc_attr( $id ) . " ' placeholder='" . esc_attr( $placeholder ) . "' " . $required . " ></br>";
                break;
            case "textarea";
                echo "<textarea class='form-control' name='" . esc_attr( $name ) . "'  id='" . esc_attr( $id ) . "' placeholder='" . esc_attr( $placeholder)  . "' " . $required . " ></textarea></br>";
                break;
            case "date";
                echo "<input class='form-control' type='date' class='htd-dpkr' name='" . esc_attr( $name ) . " '  id='" . esc_attr( $id ) . " ' placeholder='" . esc_attr( $placeholder ) . "' " . $required . " > </br>";
                break;
        }

}

    public function slugify( $str )
    {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        return $str;
    }

}
new HTD_Contact_Form_Shortcode();
