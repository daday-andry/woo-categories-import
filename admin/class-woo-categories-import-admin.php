<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/daday-andry
 * @since      1.0.0
 *
 * @package    Woo_Categories_Import
 * @subpackage Woo_Categories_Import/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Categories_Import
 * @subpackage Woo_Categories_Import/admin
 * @author     daday-andry <andrysahaedena@gmail.com>
 */
class Woo_Categories_Import_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-categories-import-admin.css', array(), $this->version, 'all' );
	}

	public function add_admin_menu_page(){
		$this->plugin_screen_hook_suffix = 
		add_submenu_page(
			'edit.php?post_type=product',
			"Categories Import", 
			"Categories Import",
			"manage_options",
			"woo-categories-import-menu",
			array($this,'admin_page'),
			'',
			55.2
		);
	}

	public function admin_page(){
		include_once 'partials/woo-categories-import-admin-display.php';

		if (isset($_FILES['woo_categories_csv_file'])) {
			$file = $_FILES['woo_categories_csv_file'];
			$file_path = $file['tmp_name'];
			
			if (!empty($file_path)) {
				$imported = $this->import_categories_from_csv($file_path);
				if ($imported) {
					echo '<div class="updated"><p>Importation réussie.</p></div>';
				} else {
					echo '<div class="error"><p>Erreur lors de l\'importation.</p></div>';
				}
			}
		}

		if(isset($_POST['woo_categories_export_csv'])){
			$this->export_categories_to_csv();
		}
	}

	public function import_categories_from_csv($file_path) {
		// Lire le fichier CSV
		$csv_data = $this->getCsvData($file_path); //array_map('str_getcsv', file($file_path));
	
		if (empty($csv_data)) {
			return false;
		}
		
		foreach ($csv_data as $row) {
			$category_name = $row[0]; 
			
			$parent_term = term_exists($category_name, 'product_cat');
			if (!$parent_term) {
				$parent_term = wp_insert_term($category_name, 'product_cat');
			}

			$subcategories = $this->getSubcategories($row[1]);
			foreach ($subcategories as $subcategory_name) {
				$subcategory_term = term_exists($subcategory_name, 'product_cat');
				if (!$subcategory_term) {
					wp_insert_term(
						$subcategory_name,
						'product_cat',
						array(
							'parent' => $parent_term['term_id']
						)
					);
				}
			}
		}
	
		return true;
	}

	public function getSubcategories($text) {
		$lines = explode("\n", $text);
		$lines = array_map('trim', $lines);
		$lines = array_filter($lines);
		return $lines;
	}

	private function getCsvData($file_path){
		$data = [];
		$fp = fopen($file_path, 'r');
		while (($row = fgetcsv($fp)) !== false) {
			$data[] = $row;
		}
		fclose($fp);

		if(isset($data[0])){
			unset($data[0]);
			$data = array_values($data);
		}

		return $data;
	}

	public function export_categories_to_csv() {
		$filename = 'categories_export_' . date('Y-m-d_H-i-s') . '.csv';
		$csv_data = "Category,Subcategory\n";
		$product_categories = get_terms(array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
		));
		foreach ($product_categories as $category) {
			$csv_data .= $category->name . ',';
	
			$subcategory_terms = get_terms(array(
				'taxonomy' => 'product_cat',
				'hide_empty' => false,
				'parent' => $category->term_id,
			));
			foreach ($subcategory_terms as $subcategory) {
				$csv_data .= $subcategory->name . ';';
			}
	
			// Supprimer le dernier point-virgule
			$csv_data = rtrim($csv_data, ';');
	
			// Passer à la ligne suivante dans le fichier CSV
			$csv_data .= "\n";
		}
	
		// Envoyer le fichier CSV en téléchargement
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $csv_data;
		exit();
	}
}
