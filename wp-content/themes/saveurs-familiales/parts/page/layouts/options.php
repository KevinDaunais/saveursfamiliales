<?php

$block_class = get_row_layout();
$layout      = $block_class .'_';

$options     = get_sub_field( $layout . 'options' );

$block_id      = 
$block_style   = 
$col_style     = 
$block_bg      = 
$block_padding = 
$block_margin  = '';

// Create all option for each block with default value
$all_keys = [
	'block_bg'        => '',
	'block_textcolor' => '',
	'block_pos'       => 'y--starts',
	'block_col_pos'   => 'x--start',

	'block_anchor'   => '',
	'block_class'    => '',
	'spacing_top'    => '',
	'spacing_bottom' => '',
];

foreach( $all_keys as $k => $v ){
	if( ! array_key_exists($k, $options) )
		$options[$k] = $v;
}

if( $options['block_class'] )
	$block_class .= ' ' . $options['block_class'];

// If bg color need to add class and create style
if( $options['block_bg']  ){

	$block_class .= " with--bgcolor";
	$block_bg     = "background-color: {$options['block_bg']};";
}


// If bg color need to add class and create style
if( $options['block_textcolor'] ){
	$block_class .= " with--color";
	$col_style    = "color: {$options['block_textcolor']};";
}

// If bg color need to add class and create style
$block_padding = "padding-top:{$options['spacing_top']}px; padding-bottom: {$options['spacing_bottom']}px;";
$block_margin  = "margin-top:{$options['margin_top']}px; margin-bottom: {$options['margin_bottom']}px;";

$block_padding_data = "{$options['spacing_top']}px|{$options['spacing_bottom']}px";
$block_margin_data  = "{$options['margin_top']}px|{$options['margin_bottom']}px";

$block_class .= ' custom--spacing par__flex';

if( $options['block_anchor'] )
	$block_id = "id='" . sanitize_title( $options['block_anchor'] ) . "'";
