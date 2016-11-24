<?php
/**
 * Plugin Name: Add Parent Category Plugin
 * Plugin URI: http://domain.com/add-parent-category-plugin/
 * Description: Adds Parent Category to every selected sub Category
 * Version: 1.0.0
 * Author: Allan Lukwago
 * Author URI: epicallan.al@gmail.com
 * Requires at least: 4.0.0
 * Tested up to: 4.0.0
 *
 * Text Domain: add-parent-category-plugin
 * Domain Path: /languages/
 *
 * @package Add_Parent_Category_plugin
 * @category Core
 * @author epicallan.al@gmail.com
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Returns the main instance of Add_Parent_Category_plugin to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Add_Parent_Category_plugin
 */
function Add_Parent_Category_plugin() {
	return Add_Parent_Category_plugin::instance();
} // End Add_Parent_Category_plugin()

add_action( 'plugins_loaded', 'Add_Parent_Category_plugin' );

/**
 * Main Add_Parent_Category_plugin Class
 *
 * @class Add_Parent_Category_plugin
 * @version	1.0.0
 * @since 1.0.0
 * @package	Add_Parent_Category_plugin
 * @author Matty
 */
final class Add_Parent_Category_plugin {
	/**
	 * Add_Parent_Category_plugin The single instance of Add_Parent_Category_plugin.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	/**
	 * The plugin directory URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plugin_url;

	/**
	 * The plugin directory path.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plugin_path;

	// Admin - Start
	/**
	 * The admin object.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $admin;

	/**
	 * The settings object.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings;
	// Admin - End

	// Post Types - Start
	/**
	 * The post types we're registering.
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $post_types = array();
	// Post Types - End
	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 */
	public function __construct () {
		$this->token 			= 'add-parent-category-plugin';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.0.0';
		require_once plugin_dir_path( __FILE__ ) . 'classes/Job.php';
		$this->process_posts();
		register_activation_hook( __FILE__, array( $this, 'install' ) );
	} // End __construct()

	/**
	 * Main Add_Parent_Category_plugin Instance
	 *
	 * Ensures only one instance of Add_Parent_Category_plugin is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Add_Parent_Category_plugin()
	 * @return Main Add_Parent_Category_plugin instance
	 */
	public static function instance () {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 * @access public
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 * @access public
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __wakeup()

	protected function process_posts() {
	  $posts = get_posts(array('numberposts' => -1) );
	  if($posts) {
	    foreach($posts as $post){
	      // get all assigned terms
	      $terms = wp_get_post_terms($post->ID, 'category' );
	      // print_r($terms);
	      foreach($terms as $term){
	        if ($term->parent != 0) {
	          wp_set_post_terms($post->ID, array($term->parent), 'category', true);
	        }
	      }
	    }
	  }
	}

	protected function get_names() {
		return array(
			'Grant Buel',
			'Bryon Pennywell',
			'Jarred Mccuiston',
			'Reynaldo Azcona',
			'Jarrett Pelc',
			'Blake Terrill',
			'Romeo Tiernan',
			'Marion Buckle',
			'Theodore Barley',
			'Carmine Hopple',
			'Suzi Rodrique',
			'Fran Velez',
			'Sherly Bolten',
			'Rossana Ohalloran',
			'Sonya Water',
			'Marget Bejarano',
			'Leslee Mans',
			'Fernanda Eldred',
			'Terina Calvo',
			'Dawn Partridge',
		);
	}
	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 */
	public function install () {
		$this->_log_version_number();
		echo "<h2> PLugin activated </h2>";
	} // End install()

	/**
	 * Log the plugin version number.
	 * @access  private
	 * @since   1.0.0
	 */
	private function _log_version_number () {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	} // End _log_version_number()
} // End Class
