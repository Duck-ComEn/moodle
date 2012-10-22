<?php

/**
 * Makes our changes to the CSS
 *
 * @param string $css
 * @param theme_config $theme
 * @return string 
 */
function solstice_process_css($css, $theme) {
	
	
	if (!empty($theme->settings->headercolor)) {
        $headercolor = $theme->settings->headercolor;
    } else {
        $headercolor = null;
    }
    $css = solstice_set_headercolor($css, $headercolor);
	
	
	if (!empty($theme->settings->menucolor)) {
        $menucolor = $theme->settings->menucolor;
    } else {
        $menucolor = null;
    }
    $css = solstice_set_menucolor($css, $menucolor);
	
    // Set the link color
    if (!empty($theme->settings->linkcolor)) {
        $linkcolor = $theme->settings->linkcolor;
    } else {
        $linkcolor = null;
    }
    $css = solstice_set_linkcolor($css, $linkcolor);

	// Set the link hover color
    if (!empty($theme->settings->linkhover)) {
        $linkhover = $theme->settings->linkhover;
    } else {
        $linkhover = null;
    }
    $css = solstice_set_linkhover($css, $linkhover);
        

    // Return the CSS
    return $css;
}

/**
 * Sets the link color variable in CSS
 *
 */
 
function solstice_set_headercolor($css, $headercolor) {
    $tag = '[[setting:headercolor]]';
    $replacement = $headercolor;
    if (is_null($replacement)) {
        $replacement = '#222222';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
} 

function solstice_set_menucolor($css, $menucolor) {
    $tag = '[[setting:menucolor]]';
    $replacement = $menucolor;
    if (is_null($replacement)) {
        $replacement = '#9f0b0b';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}
 
function solstice_set_linkcolor($css, $linkcolor) {
    $tag = '[[setting:linkcolor]]';
    $replacement = $linkcolor;
    if (is_null($replacement)) {
        $replacement = '#990000';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function solstice_set_linkhover($css, $linkhover) {
    $tag = '[[setting:linkhover]]';
    $replacement = $linkhover;
    if (is_null($replacement)) {
        $replacement = '#333333';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

