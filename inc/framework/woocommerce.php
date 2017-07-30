<?php
class HW_CustomWoo {
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_filter('wp_get_attachment_image_attributes', array($this, 'wp_get_attachment_image_attributes') ,12,3);
        add_filter('woocommerce_checkout_fields', array($this, 'woocommerce_checkout_fields'));
        add_filter('woocommerce_default_address_fields', array($this, 'woocommerce_default_address_fields'));
        add_filter('woocommerce_billing_fields', array($this, 'woocommerce_billing_fields'));
    }

    function enqueue_scripts() {
        wp_enqueue_script('hw-cloudzoom-js', TEMPLATE_URL. '/asset/cloudzoom/cloud-zoom.1.0.3.js', array('jquery'));
        wp_enqueue_style( 'hw-cloudzoom-css', TEMPLATE_URL. '/asset/cloudzoom/cloud-zoom.css', false );
    }

    function wp_get_attachment_image_attributes($attr, $attachment, $size) {
        if(isset($attr['data-cloudzoom-image-class'])) {
            $attr['class'] .= ' '. $attr['data-cloudzoom-image-class'];
            unset($attr['data-cloudzoom-image-class']);
        };
        if(isset($attr['data-zoom-type']) && $attr['data-zoom-type']=='cloudzoom') {
            unset($attr['srcset']);
        }
        return $attr;
    }

    function woocommerce_checkout_fields($fields) {
        $opt = hw_template_vars('checkout_fields', array());
        if(isset($opt['order_comments_input_class'])) $fields['order']['order_comments']['input_class'] = $opt['order_comments_input_class'];
        return $fields;
    }

    function woocommerce_default_address_fields($fields) {
        $fields = $this->_filter_form_fields($fields);
        return $fields;
    }

    function woocommerce_billing_fields($fields) {
        $fields = $this->_filter_form_fields($fields);
        return $fields;
    }

    function _filter_form_fields($fields, $opt=null) {
        if(!$opt) $opt = hw_template_vars('address_fields', array());
        foreach($fields as &$field) {
            if(!isset($field['class'])) $field['class'] = array();
            if(!isset($field['input_class'])) $field['input_class'] = array();
            if(!isset($field['label_class'])) $field['label_class'] = array();

            if(isset($opt['form_row_class'])) $field['class'] = array_merge($field['class'], $opt['form_row_class']);
            if(isset($opt['input_class'])) $field['input_class'] = array_merge($field['input_class'], $opt['input_class']);
            if(isset($opt['label_class'])) $field['label_class'] = array_merge($field['label_class'], $opt['label_class']);
        }
        return $fields;
    }
}
new HW_CustomWoo();