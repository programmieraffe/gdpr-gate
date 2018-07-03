<?php

  /**
   * GDPR Landing Page Redirect
   * @author Matthias Andrasch
   * @package Wordpress-Welcome-Redirect
   * @version 0.9
   */

  /*
    Plugin Name: GDPR gate
    Version: 0.9
    Plugin URI: 
    Description: Gets content by user on consent page - themes and plugins will not be loaded so user can confirm first. Confirmation lasts for 15 minutes. Plugin is a modification of Simple Maintenance by naa986, GPL v2 or later, plugin also GPL2 v2 or later.
    Author: Matthias Andrasch
    Author URI: https://matthias-andrasch.de
  */

    if(!defined('ABSPATH')){
      exit;
    } 

    class GDPR_GATE
    {
      var $plugin_version = '0.9';
      var $plugin_url;
      var $plugin_path;
      function __construct()
      {
        define('GDPR_GATE_VERSION', $this->plugin_version);
        define('GDPR_GATE_SITE_URL',site_url());
        define('GDPR_GATE_URL', $this->plugin_url());
        define('GDPR_GATE_PATH', $this->plugin_path());
        $this->plugin_includes();
      }

      function plugin_includes()
      {
        add_action('plugins_loaded', array($this, 'plugins_loaded_handler'));
        add_action('template_redirect', array($this, 'gdpr_gate_check_redirect')); // THE IMPORTANT FUNCTION!
      }
      function plugins_loaded_handler()
      {
        load_plugin_textdomain('simple-maintenance', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'); 
      }
      function plugin_url()
      {
        if($this->plugin_url) return $this->plugin_url;
        return $this->plugin_url = plugins_url( basename( plugin_dir_path(__FILE__) ), basename( __FILE__ ) );
      }
      function plugin_path(){   
        if ( $this->plugin_path ) return $this->plugin_path;    
        return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
      }
      function is_system_page() {
        return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
      }
      // THE IMPORTANT FUNCTION:


      function gdpr_gate_check_redirect()
      {

            // 2DO: check if user is admin/logged in properly...
          // 2DO: save page url/redirect?
          // 2DO: let SEO bots and facebook trough?

          // 2DO: CHECK IF COOKIES IS THERE?!?!

        if(is_user_logged_in()){
                //do not display gdpr page 
          // 2DO: IMPORTANT - clarify in docs!
        }
        else
        {
            // checks if it is not admin area, no login/register page, no crawler from search engines and if cookie is NOT set, then redirects to confirmation page where user can click & confirm (and cookie will be set via JS)
          if( !is_admin() && !$this->is_system_page() && !$this->is_crawler() && !isset($_COOKIE["gdpr_gate_never_gonna_give_you_up"])) { 
            $this->load_gdpr_gate_confirmation_page();
          }
          else{
              // we don't have to do something because cookie is set and confirmation was given by user
          }
        }
      }

      function is_crawler()
      {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $crawlers = 'Google|msnbot|Rambler|Yahoo|AbachoBOT|accoona|' .
        'AcioRobot|ASPSeek|CocoCrawler|Dumbot|FAST-WebCrawler|' .
        'GeonaBot|Gigabot|Lycos|MSRBOT|Scooter|AltaVista|IDBot|eStyle|Scrubby';
        $isCrawler = (preg_match("/$crawlers/", $userAgent) > 0);
        return $isCrawler;
      }
      
      function load_gdpr_gate_confirmation_page()
      {
          header('HTTP/1.0 503 Service Unavailable'); // 2DO: what is the best way for SEO?
          include_once("gdpr_gate_template.php");
          exit();
      }
    } /* eo class */
$GLOBALS['gdpr_gate'] = new GDPR_GATE();
