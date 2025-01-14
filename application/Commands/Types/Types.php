<?php

namespace OTGS\Toolset\CLI\Types;

/**
 * General Types commands.
 */
class Types extends TypesCommand {

	/**
	 * Imports a Types zip file.
	 *
	 * ## Options
	 *
	 * <file>
	 * : The zip file to import.
	 *
	 * ## Examples
	 *
	 *     wp types import file
	 *
	 * @subcommand import
	 * @synopsis <file>
	 *
	 * @param array $args The arguments of the post type query.
	 * @param array $assoc_args The associative arguments of the post type query.
	 */
	public function import( $args, $assoc_args ) {
		list( $file ) = $args;

		if ( empty ( $file ) || ! file_exists( $file ) ) {
			\WP_CLI::warning( __('You must specify a valid file.', 'toolset-cli') );

			return;
		}

		$import_file = apply_filters('types_import_from_zip_file', false, $file, null);

		if ( $import_file ) {
			\WP_CLI::success( __('The file was imported successfully.', 'toolset-cli') );
		} else {
			\WP_CLI::error( __('There was an error while importing the file.', 'toolset-cli') );
		}
	}

	/**
	 * Exports a Types file.
	 *
	 * ## Options
	 *
	 * <file>
	 * : The filename of the exported file.
	 *
	 * ## Examples
	 *
	 *     wp types export file
	 *
	 * @subcommand export
	 * @synopsis <file>
	 *
	 * @param array $args The arguments of the post type query.
	 * @param array $assoc_args The associative arguments of the post type query.
	 */
	public function export( $args, $assoc_args ) {
		list( $file ) = $args;

		if ( empty ( $file ) ) {
			\WP_CLI::warning( __('You must specify a valid file.', 'toolset-cli') );

			return;
		}

		require_once WPCF_INC_ABSPATH . '/import-export.php';
		$exported_data = wpcf_admin_export_data( false );

		if ( file_put_contents($file, $exported_data) ) {
			\WP_CLI::success( __('The file was exported successfully.', 'toolset-cli') );
		} else {
			\WP_CLI::error( __('There was an error while exporting the file.', 'toolset-cli') );
		}
	}
}
