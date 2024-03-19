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
    <div>
        <h2>CSV Importer / Export for WooCommerce Product</h2>
        
        <div style="display: flex; width:100%; justify-content: space-between">
            
            <div class="categorie-section" style="flex:1;">
                <h2>Categories</h2>
                <hr>
                <form method="post">
                    <input type="hidden" name="woo_categories_export_csv">
                    <?php submit_button('Export categories'); ?>
                </form>

                <div>
                    <h3>Import product categories</h3>
                    <form method="post" enctype="multipart/form-data">
                        <input type="file" name="woo_categories_csv_file" accept=".csv">
                        <?php submit_button('Import categories'); ?>
                    </form>
                </div>
            </div>

            <div style="flex:1;">
                <h2>Brands</h2>
                <hr>
                <form method="post">
                    <input type="hidden" name="woo_brands_export_csv">
                    <?php submit_button('Export brands'); ?>
                </form>
                <div>
                    <h3>Import product brands</h3>
                    <form method="post" enctype="multipart/form-data">
                        <input type="file" name="woo_brands_csv_file" accept=".csv">
                        <?php submit_button('Import brands'); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>