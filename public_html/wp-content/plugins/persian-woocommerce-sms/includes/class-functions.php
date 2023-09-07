<?php
function PWOO_SMS_action_links( $links ) {

	$links = array_merge( array(
		'<a style="font-weight:bold;color:red;" href="' . esc_url( admin_url( '/admin.php?page=persian-woocommerce-sms-pro' ) ) . '">پیکربندی</a>',
		'<a style="font-weight:bold;color:blue;" target="_blank" href="https://hits.ir/sms-pro">پشتیبانی PRO</a>'
	), $links );

	return $links;

}
add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'PWOO_SMS_action_links' );

update_option( 'pwoosms_hide_about_page', '0' );


add_filter( 'plugin_row_meta', 'plugin_action_meta_links', 10, 2 );

function plugin_action_meta_links( $links, $file ) {
    if ( strpos( $file, basename(__FILE__) ) ) {
        $links[] = '<a style="font-weight:bold;color:red;" href="https://hits.ir/sms-pro" target="_blank" title="پشیتبانی افزونه"> پشتیبانی PRO </a>';
        $links[] = '<a style="font-weight:bold;color:blue;" href="https://profiles.wordpress.org/persianscript/#content-plugins" target="_blank" title="مخزن وردپرس"><strong>سایر افزونه ها</strong></a>';
    }
    return $links;
}