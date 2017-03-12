<?php
/*
 * Plugin Name: WP Sudoku Plus
 * Plugin URI:
 * Description: Simple Sudoku
 * Author: opajaap
 * Author URI:
 * Text Domain: wp-sudoku-plus
 * Domain Path: /languages
 * Version: 1.3
*/

global $wpdb;

define( 'WP_SUDOKU', $wpdb->prefix . 'wp_sudoku' );

function wp_sudoku_activate_plugin() {
global $wpdb;

	$wp_sudoku = 	"CREATE TABLE " . WP_SUDOKU . " (
						id bigint(20) NOT NULL AUTO_INCREMENT,
						data tinytext NOT NULL,
						rating smallint(5) NOT NULL,
						won bigint(20) NOT NULL default 0,
						lost bigint(20) NOT NULL default 0,
						PRIMARY KEY  (id)
					) DEFAULT CHARACTER SET utf8;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	dbDelta( $wp_sudoku );

}

function wp_sudoku_fill_db() {
global $wpdb;

	$count = $wpdb->get_var( "SELECT COUNT(*) FROM `" . WP_SUDOKU . "`" );

	if ( $count >= 200000 ) {
		return;
	}

	$datafile 	= fopen( dirname(__FILE__) . '/data.txt', 'ra' );
	$ratingfile = fopen( dirname(__FILE__) . '/rating.txt', 'ra' );

	if ( ! $datafile || ! $ratingfile ) {
		return false;
	}

	$start 	= get_option( 'wp-sudoku-data-count', '0' );
	$end 	= $start + '10000';
	$cnt 	= 0;

	while ( ! feof( $datafile ) && $cnt < $end ) {
		$raw 	= fgets( $datafile, 100 );
		$id 	= substr( $raw, 0, 7 );
		$data 	= substr( $raw, 8, 81 );
		$rating = fgets( $ratingfile, 20 );
		$rating = substr( $rating, 8, 1 );
		$cnt++;

		if ( $cnt > $start ) {
			$wpdb->query( $wpdb->prepare( "INSERT INTO `" . WP_SUDOKU . "` ( `data`, `rating` ) VALUES ( %s, %d )", $data, $rating ) );
		}
	}

	for ( $rat = 1; $rat < 8; $rat++ ) {
		$ratarr[$rat] = $wpdb->get_var( "SELECT COUNT(*) FROM `" . WP_SUDOKU . "` WHERE `rating` = " . $rat );
	}

	update_option( 'wp-sudoku-rating-counts', $ratarr );

	update_option( 'wp-sudoku-data-count', $end );

	fclose( $datafile );
	fclose( $ratingfile );
}

register_activation_hook( __FILE__, 'wp_sudoku_activate_plugin' );

function wp_sudoku_deactivate_plugin() {
global $wpdb;

//	$wpdb->query( "DROP TABLE `" . WP_SUDOKU . "`" );
//	update_option( 'wp-sudoku-data-count', '0' );
}

register_deactivation_hook( __FILE__, 'wp_sudoku_deactivate_plugin' );

add_action( 'init', 'wp_sudoku_load_textdomain' );

function wp_sudoku_load_textdomain() {
global $wp_version;

	if ( $wp_version < '4.6' ) {
		load_plugin_textdomain( 'wp-sudoku-plus', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}
}

function sudoku( $size = 16 ) {
global $wpdb;

	if ( ! defined( 'DOING_AJAX' ) ) {
		if ( get_option( 'wp-sudoku-data-count', '0' ) < '200000' ) {
			wp_sudoku_fill_db();
		}
	}

	$size = intval( strval( intval( $size ) ) );

	$s = $size ? $size : 16;
	if ( $s < 8 ) $s = 8;
	if ( $s > 32 ) $s = 32;
	$si = 3 * $s + 2;
	$sb = 3 * $si + 4;
	$sm = 3 * $sb + 8;

	$ratarr = get_option( 'wp-sudoku-rating-counts', array( '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0 ) );

	// A puzzle of a certain rating requested?
	if ( isset( $_REQUEST['rating'] ) ) {

		// Security check
		$rating = strval( intval( $_REQUEST['rating'] ) );
		if ( $rating < '1' || $rating > '7' ) {
			_e( 'Security check failure', 'wp-sudoku-plus' );
			echo ' (1)';
			exit;
		}

		// Find a puzzle of the requested rating
		$puzzle = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `" . WP_SUDOKU . "` WHERE `rating` = %d ORDER BY RAND() LIMIT 1", $rating ), ARRAY_A );
		$puzno  = $puzzle['id'];
		$data   = $puzzle['data'];
	}

	// A puzzle of a certain id requested?, else use a random id
	else {

		// Security check
		$puzno 	= isset( $_REQUEST['puzno'] ) ? $_REQUEST['puzno'] : rand( 1, get_option( 'wp-sudoku-data-count' ) );
		$puzno 	= strval( intval( $puzno ) );
		if ( $puzno < '0' || $puzno > '200000' ) {
			_e( 'Security check failure', 'wp-sudoku-plus' );
			echo ' (2)';
			exit;
		}

		// Puzno = 0 means empty puzzle
		if ( $puzno == '0' ) {
			$data = '000000000000000000000000000000000000000000000000000000000000000000000000000000000';
			$rating = '0';
		}

		// Puzno <> 0
		else {
			$puzzle = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `" . WP_SUDOKU . "` WHERE `id` = %s", $puzno ), ARRAY_A );
			$data 	= $puzzle['data'];
			$rating = $puzzle['rating'];
		}
	}

	$result = '';

	// Open overall container
	if ( ! defined( 'DOING_AJAX' ) ) {
		$result .= 	'<div' .
						' id="sud-container"' .
						' style="position:relative;width:'.$sm.'px;"' .
						' >';
	}
	$result .=
		'<style>' .
			'#sud-container table {' .
				'margin-top:2px;' .
				'border:1px solid #cccccc;' .
			'}' .
			'#sud-container tr td {' .
				'padding:2px 4px;' .
				'border:1px solid #cccccc;' .
			'}' .
			'.sud-block-box {' .
				'box-sizing:border-box;' .
				'border:2px solid #777;' .
				'width:' . $sb . 'px;' .
				'height:' . $sb . 'px;' .
				'position:relative;' .
				'float:left;' .
			'}' .
			'.sud-item-box {' .
				'box-sizing:border-box;' .
				'border:1px solid #333;' .
				'width:' . $si . 'px;' .
				'height:' . $si . 'px;' .
				'position:relative;' .
				'float:left;' .
				'font-size:' . ( (  $s - 2 ) * 3 ) . 'px;' .
				'line-height:' . $si . 'px;' .
				'text-align:center;' .
			'}' .
			'.sud-button-box {' .
				'box-sizing:border-box;' .
				'border:1px solid #777;' .
				'width:' . $s . 'px;' .
				'height:' . $s . 'px;' .
				'position:absolute;' .
				'float:left;' .
				'font-size:' . ( $s - 2 ) . 'px;' .
				'line-height:' . ( $s - 2 ) . 'px;' .
				'text-align:center;' .
				'cursor:pointer;' .
			'}' .
			'#wp-sudoku-legenda, #wp-sudoku-rating, #wp-sudoku-help {' .
				'font-family:Helvetica;' .
				'font-size:' . $s . 'px;' .
				'line-height:' . ( $s +'2' ) . 'px;' .
			'}' .
			'#wp-sudoku-legenda, #wp-sudoku-help {' .
				'width:' . $sm . 'px;' .
			'}' .
			'#wp-sudoku-help {' .
				'display:none;' .
			'}' .
			'#sud-ajaxspin {' .
				'visibility:hidden;' .
				'z-index:1;' .
				'position:absolute;' .
				'top:' . ( $sm / 2 - 33 ) . 'px;' .
				'left:' . ( $sm / 2 - 33 ) . 'px;' .
				'box-shadow:none !important;' .
			'}' .
			'.sud-small-spin {' .
				'width:' . $s . 'px;' .
				'box-shadow:none !important;' .
			'}' .
		'</style>' .
		'<script>' .
			'var sudSmallSpinnerUrl = "' . plugins_url( basename( dirname( __FILE__ ) ) . '/smallspinner.gif' ) . '"' .
		'</script>';

	$result .= '
		<div' .
			' class="sud-main-box"' .
			'style="' .
				'box-sizing:border-box;' .
				'border:4px solid #333;' .
				'width:' . $sm . 'px;' .
				'height:' . $sm . 'px;' .
				'position:relative;' .
				'font-family:Helvetica;' .
				'"' .
			' oncontextmenu="return false;"' .
			' >' .
			'<input type="hidden" id="puzno" value="'.$puzno.'" ></input>' .
			'<input type="hidden" id="rating" value="'.$rating.'" ></input>' .
			'<input type="hidden" id="nonce" value="'.wp_create_nonce( 'sudoku-'.$puzno ).'" ></input>';
			for ( $ybox = 0; $ybox < 3; $ybox++ ) {
				for ( $xbox = 0; $xbox < 3; $xbox++ ) {
					$result .= '
					<div' .
						' class="' .
							' sud-block-box' .
							' sud-block-box-y-' . $ybox .
							' sud-block-box-x-' . $xbox .
							' sud-block-box-b-' . ( $ybox * 3 + $xbox ) .
							'"' .
						' style="' .
							( floor( ( $xbox + $ybox ) / 2 ) * 2 == ( $xbox + $ybox ) ? 'background-color:#ccc;' : '' ) .
							'"' .
						' >';
						for ( $yitm = 0; $yitm < 3; $yitm++ ) {
							for ( $xitm = 0; $xitm < 3; $xitm++ ) {
								$i = ( ( $ybox * 3 ) + $yitm ) * 9 + $xbox * 3 + $xitm;
								$value = substr( $data, $i, 1 );
								$result .=
								'<div' .
									' class="' .
										' sud-item-box' .
										' sud-item-box-y-' . ( $ybox * 3 + $yitm ) .
										' sud-item-box-x-' . ( $xbox * 3 + $xitm ) .
										'"' .
									' >';
									if ( $value ) {
										$result .= 	'<div' .
													' id="sud-' . $i . '"' .
													' style="' .
														'color:#007;' .
														'"' .
													' >' .
													$value .
												'</div>';
									}
									else {
										for ( $ybtn = 0; $ybtn < 3; $ybtn++ ) {
											$t = $ybtn * $s;
											for ( $xbtn = 0; $xbtn < 3; $xbtn++ ) {
												$l = $xbtn * $s;
												$result .=
												'<div' .
													' id="sud-button-'.( $ybox * 3 + $yitm ).'-'.( $xbox * 3 + $xitm ).'-'.( $ybtn * 3 + $xbtn + 1 ).'"' .
													' class="'  .
													' sud-button-box' .
													' sud-button-box-y-' . ( $ybox * 3 + $yitm ) . '-v-' . ( $ybtn * 3 + $xbtn + 1 ) .
													' sud-button-box-x-' . ( $xbox * 3 + $xitm ) . '-v-' . ( $ybtn * 3 + $xbtn + 1 ) .
													' sud-button-box-b-' . ( $ybox * 3 + $xbox ) . '-v-' . ( $ybtn * 3 + $xbtn + 1 ) .
													' sud-button-box-v-' . ( $ybtn * 3 + $xbtn + 1 ) .
													' sud-button-box-y-' . ( $ybox * 3 + $yitm ) . '-x-' . ( $xbox * 3 + $xitm ) . '-v-' . ( $ybtn * 3 + $xbtn + 1 ) .
													'"' .
													' style="' .
														'top:' . $t . 'px;' .
														'left:' . $l . 'px;' .
														'display:block;' .
														'visibility:visible;' .
													'"' .
													' onmousedown="sudButtonClick(event,' . ( $ybox * 3 + $yitm ) . ', ' . ( $xbox * 3 + $xitm ) . ', ' . ( $ybtn * 3 + $xbtn + 1 ) . ' );"' .
													' >' .
													( $ybtn * 3 + $xbtn + 1 ) .
												'</div>';
											}
										}
									}
									$result .= '<div id="sud-' . $i . '" ></div>';
								$result .=
								'</div>';
							}
						}

					$result .=
					'</div>';
				}
			}


		$result .=
		'</div>';

		$result .= '
				<script>';
		$result .= 'sudAjaxUrl="' . admin_url( 'admin-ajax.php' ) . '";';
		for ( $i = 0; $i < 81; $i++ ) {
			$v = substr( $data, $i, 1 );
			if ( $v ) {
				$y = floor( $i / 9 );
				$x = $i % 9;
				$result .= 'sudButtonDestroy(' . $y . ', ' . $x . ', ' . $v . ', true );';
			}
		}
		$result .= '</script>';

		$same  = get_permalink();
		
		if ( is_array( $puzzle ) && isset( $puzzle['id'] ) ) {
			if ( strpos( $same, '?' ) ) {
				$same .= '&puzno=' . $puzzle['id'];
			}
			else {
				$same .= '?puzno=' . $puzzle['id'];
			}
		}
		
		$new   = get_permalink();
		if ( isset( $_REQUEST['rating'] ) ) {
			if ( strpos( $new, '?' ) ) {
				$new .= '&rating=' . $_REQUEST['rating'];
			}
			else {
				$new .= '?rating=' . $_REQUEST['rating'];
			}
		}
		$empty = get_permalink();
		if ( strpos( $empty, '?' ) ) {
			$empty .= '&puzno=0';
		}
		else {
			$empty .= '?puzno=0';
		}

		// Open legenda container
		$result .=
				'<div' .
					' id="wp-sudoku-legenda"' .
					' >';

					// Statistics this puzzle
					if ( $puzno ) {
		$result .=
						__( 'Puzzle', 'wp-sudoku-plus' ) .
						' #' . $puzzle['id'] . ', ' .
						__( 'Won', 'wp-sudoku-plus' ) .
						': ' .
						'<span' .
							' id="won"' .
							' style="cursor:pointer;"' .
							' title="' . esc_attr( sprintf( __( 'Total times puzzle #%d has been solved', 'wp-sudoku-plus' ), $puzzle['id'] ) ) . '"' .
							' >' .
							$puzzle['won'] .
						'</span>, ' .
						__( 'Lost', 'wp-sudoku-plus' ) .
						': ' .
						'<span' .
							' id="lost"' .
							' style="cursor:pointer;"' .
							' title="' . esc_attr( sprintf( __( 'Total times a visitor failed to solve puzzle #%d', 'wp-sudoku-plus' ), $puzzle['id'] ) ) . '"' .
							' >' .
							$puzzle['lost'] .
						'</span>.<br />';
					}

					// Level selection box
		$result .=
					__( 'Level', 'wp-sudoku-plus' ) .
					': ' .
					'<select' .
						' id="wp-sudoku-rating"' .
						' onchange="sudGetPuzzle( false, this.value, \'' . get_permalink() . '\', ' . $s . ')"' .
						' style="margin:0;padding:0;"'.
						' >';
						for ( $i = 1; $i < 8; $i++ ) {
		$result .=
							'<option' .
								' value="' . $i . '"' .
								( $rating == $i ? ' selected="selected" ' : '' ) .
								( $ratarr[$i] == 0 ? ' disabled="disabled"' : '' ) .
								'>' .
								$i .
							'</option>';
						}
		$result .=
					'</select>' .
					', ';

					// Total statistics this level
					if ( $puzno ) {
						$temp = $wpdb->get_results( $wpdb->prepare( "SELECT `won` FROM `" . WP_SUDOKU . "` WHERE `rating` = %d AND `won` <> 0", $rating ), ARRAY_A );
						$totwon = 0;
						if ( $temp ) {
							foreach ( $temp as $t ) {
								$totwon += $t['won'];
							}
						}
						$temp = $wpdb->get_results( $wpdb->prepare( "SELECT `lost` FROM `" . WP_SUDOKU . "` WHERE `rating` = %d AND `lost` <> 0", $rating ), ARRAY_A );
						$totlost = 0;
						if ( $temp ) {
							foreach ( $temp as $t ) {
								$totlost += $t['lost'];
							}
						}
		$result .=
						__( 'Won', 'wp-sudoku-plus' ) .
						': ' .
						'<span' .
							' id="totwon"' .
							' style="cursor:pointer;"' .
							' title="' . esc_attr( sprintf( __( 'Total times a puzzle of level %d has been solved', 'wp-sudoku-plus' ), $rating ) ) . '"' .
							' >' .
							$totwon .
						'</span>, ' .
						__( 'Lost', 'wp-sudoku-plus' ) .
						': ' .
						'<span' .
							' id="totlost"' .
							' style="cursor:pointer;"' .
							' title="' . esc_attr( sprintf( __( 'Total times a visitor failed to solve a puzzle of level %d', 'wp-sudoku-plus' ), $rating ) ) . '"' .
							' >' .
							$totlost .
						'</span>.' .
						'<br />';
					}

					// New puzzle links
		$result .=
					'<a' .
						' style="cursor:pointer;"' .
						' onclick="sudGetPuzzle( ' . $puzno . ', false, \'' . $same . '\', ' . $s . ' )"' .
						' >' .
						__('Same', 'wp-sudoku-plus' ) .
					'</a> ' .
					' <a' .
						' style="cursor:pointer;"' .
						' onclick="sudGetPuzzle( false, ' . $rating . ', \'' . $new . '\', ' . $s . ' )"' .
						' >' .
						__('New', 'wp-sudoku-plus' ) .
					'</a> ' .
					' <a' .
						' style="cursor:pointer;"' .
						' onclick="sudGetPuzzle( 0, false, \'' . $empty . '\', ' . $s . ' )"' .
						' >' .
						__( 'Empty', 'wp-sudoku-plus' ) .
					'</a> ' .
					'<a' .
						' style="cursor:pointer;"' .
						' onclick="jQuery(\'#wp-sudoku-help\').css(\'display\', \'block\');"' .
						' >' .
						__( 'Help', 'wp-sudoku-plus' ) .
					'</a>';

				// Close legenda container
	$result .=
				'</div>';

				// Help and info box
	$result .= 	'<div' .
					' id="wp-sudoku-help"' .
					' >' .
					__( 'Click left to select, click right to remove option, type digit to show.', 'wp-sudoku-plus' ) . ' ' .
					sprintf( __( 'There are %d puzzles available.', 'wp-sudoku-plus' ), $wpdb->get_var( "SELECT COUNT(*) FROM `" . WP_SUDOKU . "` " ) ) .
					'<table style="border-collapse:collapse;width:100%;" >' .
						'<thead>' .
							'<td>' . __( 'Level', 'wp-sudoku-plus' ) . '</td>' .
							'<td>' . __( 'Total', 'wp-sudoku-plus' ) . '</td>' .
							'<td>' . __( 'Won', 'wp-sudoku-plus' ) . '</td>' .
							'<td>' . __( 'Lost', 'wp-sudoku-plus' ) . '</td>' .
						'</thead>' .
						'<tbody>';
						for ( $level = 1; $level < 8; $level++ ) {
	$result .= 				'<tr>' .
								'<td>' . $level . '</td>' .
								'<td>' . $wpdb->get_var( "SELECT COUNT(*) FROM `" . WP_SUDOKU . "` WHERE `rating` = " . $level ) . '</td>' .
								'<td id="sud-'.$level.'-won" >' . $wpdb->get_var( "SELECT COUNT(*) FROM `" . WP_SUDOKU . "` WHERE `rating` = " . $level . " AND `won` <> 0" ) . '</td>' .
								'<td id="sud-'.$level.'-lost" >' . $wpdb->get_var( "SELECT COUNT(*) FROM `" . WP_SUDOKU . "` WHERE `rating` = " . $level . " AND `lost` <> 0" ) . '</td>' .
							'</tr>';
						}
	$result .= 			'</tbody>' .
					'</table>' .
				'</div>';

			// Ajax spinner
	$result .=
			'<img' .
				' id="sud-ajaxspin"' .
				' src="' . plugins_url( basename( dirname( __FILE__ ) ) . '/bigspinner.gif' ) . '"' .
			' />';

	// Close overall container
	if ( ! defined( 'DOING_AJAX' ) ) {
		$result .= '</div>';
	}

	return $result;
}

function sudoku_shortcode_handler( $xatts ) {
	$atts = shortcode_atts( array(
									'size' 		=> '',
								),
							$xatts
						);
	$size = floor( $atts['size'] );

	return sudoku( $size );
}

// Enqueue script
function sudoku_add_scripts() {
	wp_enqueue_script( 'wp-sudoku-plus', plugins_url( '/wp-sudoku-plus.js' , __FILE__ ), array( 'jquery' ) );
}

function wp_sudoku_ajax_callback() {
global $wpdb;

	if ( ! isset( $_REQUEST['wp-sudoku-action'] ) ) return;

	$action 	= $_REQUEST['wp-sudoku-action'];
	$puzno 		= isset( $_REQUEST['puzno'] ) ? strval( intval( $_REQUEST['puzno'] ) ) : '0';
	$prevpuzno 	= isset( $_REQUEST['prevpuzno'] ) ? strval( intval( $_REQUEST['prevpuzno'] ) ) : '0';
	$nonce 		= isset( $_REQUEST['nonce'] ) ? $_REQUEST['nonce'] : '0';

	if ( ! wp_verify_nonce( $nonce, 'sudoku-'.$prevpuzno ) ) {
		_e( 'Security check failure', 'wp-sudoku-plus' );
		exit;
	}

	switch ( $action ) {
		case 'sudfail':
			$failcount = $wpdb->get_var( "SELECT `lost` FROM `" . WP_SUDOKU . "` WHERE `id` = " . $puzno );
			$failcount++;
			$wpdb->query( "UPDATE `" . WP_SUDOKU . "` SET `lost` = " . $failcount . " WHERE `id` = " . $puzno );
			echo $failcount;
			break;
		case 'sudwin':
			$wincount = $wpdb->get_var( "SELECT `won` FROM `" . WP_SUDOKU . "` WHERE `id` = " . $puzno );
			$wincount++;
			$wpdb->query( "UPDATE `" . WP_SUDOKU . "` SET `won` = " . $wincount . " WHERE `id` = " . $puzno );
			echo $wincount;
			break;
		case 'sudget':
			echo sudoku( $_REQUEST['size'] );
			break;
	}

	exit;
}

// Init
add_action( 'wp_enqueue_scripts', 'sudoku_add_scripts' );
add_shortcode( 'sudoku', 'sudoku_shortcode_handler' );
add_action( 'wp_ajax_wp_sudoku', 'wp_sudoku_ajax_callback' );
add_action( 'wp_ajax_nopriv_wp_sudoku', 'wp_sudoku_ajax_callback' );
