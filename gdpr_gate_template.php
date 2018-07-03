<?php
// code modification of simple-maintenance (GPLv2 or later)
$plugin_namespace = "gdpr-gate";

$language = get_bloginfo('language');
$charset = get_bloginfo('charset');
$name = get_bloginfo('name');
$url = get_bloginfo('url');
$link_text = sprintf(wp_kses(__('<a title="%s" href="%s">%s</a> is currently undergoing scheduled maintenance.', 'simple-maintenance'), array('a' => array('href' => array(), 'title' => array()))), $name, esc_url($url), $name);


// wordpress privacy policy page option
$wp_page_for_privacy_policy_id = get_option('wp_page_for_privacy_policy');
if($wp_page_for_privacy_policy_id != 0){
    $post   = get_post($wp_page_for_privacy_policy_id);
    // sanitize content so that no embeds are possible
    $privacy_policy_content =   strip_tags( $post->post_content , "<h1><h2><h3><h4><h5><h6><hr><b><i><u><a><br><ul><li><ol><p><blockquote>");
} 

/* current page content - not used by now 
$obj_id = get_queried_object_id();
$post   = get_post($wp_page_for_privacy_policy_id);
// sanitize content so that no embeds are possible
$post_page_text_content =   strip_tags( $post->post_content , "<h1><h2><h3><h4><h5><h6><hr><b><i><u><a><br><ul><li><ol><p><blockquote>"); */

?>
<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
    <meta charset="<?php echo $charset; ?>" />
    <meta name="viewport" content="width=device-width">
    <title><?php echo $name; ?> &#8250; <?php _e('GDPR Gate', $plugin_namespace)?></title>
    <link rel="stylesheet" href="<?php echo GDPR_GATE_URL.'/gdpr-gate.css'; ?>" type="text/css" media="all" />	
</head>
<body>

    <div id="wrap">
        <h1><?php _e('GDPR gate', $plugin_namespace)?></h1>

        <h2><?php _e('Privacy policy', $plugin_namespace)?></h2>

        <p><?php _e("This website is built with Wordpress, a open source software for blogs and multimedia content. This website relies on external content and contains embeds from third party providers, such as YouTube videos, Twitter postings, Instagram photos, external images and more - or external webdevelopment resources such as Google Fonts or software provided by so called CDNs. All of this content will be loaded from third party providers, which may track you - details can be found in the privacy policies of the companies offering these services. If you do not agree to these embeds, please DO NOT use this website. Advice: You can use tools such as Privacy Badger by EFF to control your privacy online. Thank you very much!", $plugin_namespace)?></p>

        <p><?php _e('This is the text-only preview of the privacy policy:', $plugin_namespace)?></p>

<?php if(isset($privacy_policy_content)){ ?>
    <div class="text-content-window"><?php echo $privacy_policy_content; ?>
    </div>
<?php } /* eif pcontent */ ?>

<p class="consent-box"><i><button id="confirm"><?php _e('I agree to the privacy policy', $plugin_namespace)?></button><br> <?php _e('By agreeing to this privacy policy there will be an cookie stored on your computer which documents your confirmation for 15 minutes. To revoke your confirmation earlier, please delete your cookies in your browser. You will be redirected to the page content after clicking agree.', $plugin_namespace)?></i></p>

    <script type="text/javascript" src="<?php echo GDPR_GATE_URL.'/jquery.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo GDPR_GATE_URL.'/js-cookie.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo GDPR_GATE_URL.'/gdpr-gate.js'; ?>"></script>
</body>
</html>