<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/daday-andry
 * @since      1.0.0
 *
 * @package    Woo_Categories_Import
 * @subpackage Woo_Categories_Import/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <div style="display:flex; align-items: center; justify-content: space-between;">
        <h2>CSV Importer / Export for WooCommerce Product categories</h2>
        <form method="post">
            <input type="hidden" name="woo_categories_export_csv">
            <?php submit_button('Export'); ?>
        </form>

    </div>
    
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="woo_categories_csv_file" accept=".csv">
        <?php submit_button('Import'); ?>
    </form>
</div>