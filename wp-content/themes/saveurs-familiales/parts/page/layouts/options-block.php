<?php

$name = $block['name'];

$name = str_replace("acf/", "",$name);
$name = str_replace("-", "_",$name);

$block_class = $name;
$layout      = $block_class .'_';

$data     = $block['data'];

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


if( array_key_exists('block_class', $data) )
	$block_class .= ' ' . $data['block_class'];

// If bg color need to add class and create style
if( array_key_exists('block_bg', $data) ){

	$block_class .= " with--bgcolor";
	$block_bg     = "background-color: {$data['block_bg']};";
}


// If bg color need to add class and create style
if( array_key_exists('block_textcolor', $data) ){
	$block_class .= " with--color";
	$col_style    = "color: {$data['block_textcolor']};";
}

// If bg color need to add class and create style

if( array_key_exists('spacing_top', $data)  ){

    $block_padding = "padding-top:{$data['spacing_top']}px; padding-bottom: {$data['spacing_bottom']}px;";
    $block_padding_data = "{$data['spacing_top']}px|{$data['spacing_bottom']}px";
}

if( array_key_exists('margin_top', $data)  ){

    $block_margin  = "margin-top:{$data['margin_top']}px; margin-bottom: {$data['margin_bottom']}px;";
    $block_margin_data  = "{$data['margin_top']}px|{$data['margin_bottom']}px";
}

$block_class .= ' custom--spacing par__flex';

if( array_key_exists('block_anchor', $data) )
    $block_id = "id='" . sanitize_title( $data['block_anchor'] ) . "'";


