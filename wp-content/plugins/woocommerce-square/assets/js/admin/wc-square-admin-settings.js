/* global wc_square_admin_settings */

/**
 * WooCommerce Square scripts for admin product pages.
 *
 * @since 2.0.0
 */
jQuery( document ).ready( ( $ ) => {
	const pagenow = window.pagenow || '';

	// bail if not on the admin settings page.
	if ( 'woocommerce_page_wc-settings' !== pagenow ) {
		return;
	}

	if ( ! wc_square_admin_settings.is_sandbox ) {
		// Hide sandbox settings if is_sandbox is set.
		$( '#wc_square_sandbox_settings' ).hide();
		$( '#wc_square_sandbox_settings' ).next().hide();
		$( '.wc_square_sandbox_settings' ).closest( 'tr' ).hide();
	}

	$( '#wc_square_system_of_record' ).on( 'change', ( e ) => {
		const system_of_record = $( e.target ).val();
		const $inventory_sync = $( '#wc_square_enable_inventory_sync' );
		const $inventory_sync_row = $inventory_sync.closest( 'tr' );

		// toggle the "Sync inventory" setting depending on the SOR.
		if ( 'square' === system_of_record || 'woocommerce' === system_of_record ) {
			$inventory_sync.next( 'span' ).html( wc_square_admin_settings.i18n.sync_inventory_label[ system_of_record ] );
			$inventory_sync_row.find( '.description' ).html( wc_square_admin_settings.i18n.sync_inventory_description[ system_of_record ] );
			$inventory_sync_row.show();
		} else {
			$inventory_sync.prop( 'checked', false );
			$inventory_sync_row.hide();
		}

		// toggle the "Hide missing products" setting depending on the SOR.
		if ( 'square' === system_of_record ) {
			$( '#wc_square_hide_missing_products' ).closest( 'tr' ).show();
		} else {
			$( '#wc_square_hide_missing_products' ).closest( 'tr' ).hide();
		}
	} ).trigger( 'change' );

	$( '.js-import-square-products' ).on( 'click', ( e ) => {
		e.preventDefault();

		new $.WCBackboneModal.View( {
			target: 'wc-square-import-products',
		} );

		$( '#btn-close' ).on( 'click', ( e ) => {
			e.preventDefault();

			$( 'button.modal-close' ).trigger( 'click' );
		} );
	} );

	// initiate a manual sync.
	$( '#wc-square-sync' ).on( 'click', ( e ) => {
		e.preventDefault();

		// open a modal dialog.
		new $.WCBackboneModal.View( {
			target: 'wc-square-sync',
		} );

		// enable cancel sync button.
		$( '#btn-close' ).on( 'click', ( e ) => {
			e.preventDefault();

			$( 'button.modal-close' ).trigger( 'click' );
		} );
	} );

	// Listen for wc_backbone_modal_response event handler.
	$( document.body ).on( 'wc_backbone_modal_response', ( e, target ) => {
		let data;

		switch ( target ) {
			case 'wc-square-import-products':
				// Add Block overlay since the modal exits immediately
				// after wc_backbone_modal_response is triggered.
				$( '#wpbody' ).block( {
					message: null,
					overlayCSS: {
						opacity: '0.2',
					},
					onBlock: function onBlock() {
						$( '.blockUI.blockOverlay' ).css(
							{
								position: 'fixed',
							}
						);
					},
				} );

				const update_during_import = $( '#wc-square-import-product-updates' ).prop( 'checked' );
				data = {
					action: 'wc_square_import_products_from_square',
					dispatch: wc_square_admin_settings.sync_in_background,
					security: wc_square_admin_settings.import_products_from_square,
					update_during_import,
				};

				$.post( wc_square_admin_settings.ajax_url, data, ( response ) => {
					const message = response.data ? response.data : null;

					if ( message ) {
						alert( message );
					}

					location.reload();
				} );
				break;

			case 'wc-square-sync':
				$( 'table.sync' ).block( {
					message: null,
					overlayCSS: {
						opacity: '0.2',
					},
				} );

				$( 'table.records' ).block( {
					message: null,
					overlayCSS: {
						opacity: '0.2',
					},
				} );

				$( '#wc-square_clear-sync-records' ).prop( 'disabled', true );

				data = {
					action: 'wc_square_sync_products_with_square',
					dispatch: wc_square_admin_settings.sync_in_background,
					security: wc_square_admin_settings.sync_products_with_square,
				};

				$.post( wc_square_admin_settings.ajax_url, data, ( response ) => {
					if ( response && response.success ) {
						location.reload();
					} else {
						$( '#wc-square_clear-sync-records' ).prop( 'disabled', false );
						$( 'table.sync' ).unblock();
						$( 'table.records' ).unblock();
					}
				} );
				break;
		}
	} );

	// Clear sync records history.
	const noRecordsFoundRow = '<tr><td colspan="4"><em>' + wc_square_admin_settings.i18n.no_records_found + '</em></td></tr>';
	$( '#wc-square_clear-sync-records' ).on( 'click', ( e ) => {
		e.preventDefault();

		$( 'table.records' ).block( {
			message: null,
			overlayCSS: {
				opacity: '0.2',
			},
		} );

		const data = {
			action: 'wc_square_handle_sync_records',
			id: 'all',
			handle: 'delete',
			security: wc_square_admin_settings.handle_sync_with_square_records,
		};

		$.post( wc_square_admin_settings.ajax_url, data, ( response ) => {
			if ( response && response.success ) {
				$( 'table.records tbody' ).html( noRecordsFoundRow );
				$( '#wc-square_clear-sync-records' ).prop( 'disabled', true );
			} else {
				if ( response.data ) {
					alert( response.data );
				}
				console.log( response );
			}
			$( 'table.records' ).unblock();
		} );
	} );

	// Individual sync records actions.
	$( '.records .actions button.action' ).on( 'click', ( e ) => {
		e.preventDefault();

		$( 'table.records' ).block( {
			message: null,
			overlayCSS: {
				opacity: '0.2',
			},
		} );
		const recordId = $( e.currentTarget ).data( 'id' );
		const action = $( e.currentTarget ).data( 'action' );
		const data = {
			action: 'wc_square_handle_sync_records',
			id: recordId,
			handle: action,
			security: wc_square_admin_settings.handle_sync_with_square_records,
		};

		$.post( wc_square_admin_settings.ajax_url, data, ( response ) => {
			if ( response && response.success ) {
				const rowId = '#record-' + recordId;

				if ( 'delete' === action ) {
					$( rowId ).remove();

					if ( ! $( 'table.records tbody tr' ).length ) {
						$( 'table.records tbody' ).html( noRecordsFoundRow );
						$( '#wc-square_clear-sync-records' ).prop( 'disabled', true );
					}
				} else if ( 'resolve' === action || 'unsync' === action ) {
					$( rowId + ' .type' ).html( '<mark class="resolved"><span>' + wc_square_admin_settings.i18n.resolved + '</span></mark>' );
					$( rowId + ' .actions' ).html( '&mdash;' );
				}
			} else {
				if ( response && response.data ) {
					alert( response.data );
				}

				console.log( {
					record: recordId,
					action,
					response,
				} );
			}
			$( 'table.records' ).unblock();
		} );
	} );

	// Add explicit square environment to post data to deal with swapping between production and sandbox in the back end.
	$( 'form' ).on( 'submit', ( e ) => {
		const environment = $( '#wc_square_enable_sandbox' ).is( ':checked' ) ? 'sandbox' : 'production';

		$( e.target ).append(
			$( '<input>',
				{
					type: 'hidden',
					name: 'wc_square_environment',
					value: environment,
				}
			)
		);
	} );

	/**
	 * Returns a job sync status.
	 *
	 * @since 2.0.0
	 *
	 * @param {string} job_id
	 */
	const getSyncStatus = ( job_id ) => {
		let $progress = $( 'span.progress' );

		if ( ! $progress || 0 === $progress.length ) {
			$( 'p.sync-result' ).append( ' <span class="progress" style="display:block"></span>' );
			$progress = $( 'span.progress' );
		}

		const data = {
			action: 'wc_square_get_sync_with_square_status',
			security: wc_square_admin_settings.get_sync_with_square_status_nonce,
			job_id,
		};

		$.post( wc_square_admin_settings.ajax_url, data, ( response ) => {
			if ( response && response.data ) {
				if ( response.success && response.data.id ) {
					// start the progress spinner.
					$( 'table.sync .spinner' ).css( 'visibility', 'visible' );
					// disable interacting with records as more could be added during a sync process.
					$( '#wc-square_clear-sync-records' ).prop( 'disabled', true );
					$( 'table.records .actions button' ).prop( 'disabled', true );
					// continue if the job is in progression.
					if ( 'completed' !== response.data.status && 'failed' !== response.data.status ) {
						let progress = ' ';
						// update progress info in table cell.
						if ( 'product_import' === response.data.action ) {
							progress += wc_square_admin_settings.i18n.skipped + ': ' + parseInt( response.data.skipped_products_count, 10 ) + '<br/>';
							progress += wc_square_admin_settings.i18n.updated + ': ' + parseInt( response.data.updated_products_count, 10 ) + '<br/>';
							progress += wc_square_admin_settings.i18n.imported + ': ' + parseInt( response.data.imported_products_count, 10 );
						} else if ( response.data.percentage ) {
							progress += parseInt( response.data.percentage, 10 ) + '%';
						}

						$progress.html( progress );

						// recursion update loop until we're 'completed' (add a long timeout to avoid missing callback return output).
						setTimeout( () => {
							getSyncStatus( response.data.id );
						}, 30 * 1000 );
					} else {
						// reload page, display updated sync dates and any sync records messages.
						location.reload(); // unlikely job processing exception.
					}
				} else {
					$( '#wc-square_clear-sync-records' ).prop( 'disabled', false );
					$( 'table.records .actions button' ).prop( 'disabled', false );
					$( 'table.sync .spinner' ).css( 'visibility', 'hidden' );
					console.log( response );
				}
			}
		} );
	};

	// run once on page load.
	if ( wc_square_admin_settings.existing_sync_job_id ) {
		getSyncStatus( wc_square_admin_settings.existing_sync_job_id );
	}

	// Show/hide Digital Wallet Settings on Square gateway settings page.
	$( '#woocommerce_square_credit_card_enable_digital_wallets' ).on( 'change', () => {
		const wallet_settings = $( '.wc-square-digital-wallet-options' );

		if ( $( '#woocommerce_square_credit_card_enable_digital_wallets' ).is( ':checked' ) ) {
			wallet_settings.closest( 'tr' ).show();
		} else {
			wallet_settings.closest( 'tr' ).hide();
		}
	} ).trigger( 'change' );
} );
