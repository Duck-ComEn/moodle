<?php

function aardvark_process_css($css, $theme) {

    // Set the menu hover color
    if (!empty($theme->settings->menuhovercolor)) {
        $menuhovercolor = $theme->settings->menuhovercolor;
    } else {
        $menuhovercolor = null;
    }
    $css = aardvark_set_menuhovercolor($css, $menuhovercolor);
    
	// Set the background image for the graphic wrap 
    if (!empty($theme->settings->graphicwrap)) {
        $graphicwrap = $theme->settings->graphicwrap;
    } else {
        $graphicwrap = null;
    }
    $css = aardvark_set_graphicwrap($css, $graphicwrap);
	
    return $css;
}



function aardvark_set_menuhovercolor($css, $menuhovercolor) {
    $tag = '[[setting:menuhovercolor]]';
    $replacement = $menuhovercolor;
    if (is_null($replacement)) {
        $replacement = '#5faff2';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function aardvark_set_graphicwrap($css, $graphicwrap) {
	global $OUTPUT;  
	$tag = '[[setting:graphicwrap]]';
	$replacement = $graphicwrap;
	if (is_null($replacement)) {
 		$replacement = $OUTPUT->pix_url('graphics/bg', 'theme');
 	}
	$css = str_replace($tag, $replacement, $css);
	return $css;
}



