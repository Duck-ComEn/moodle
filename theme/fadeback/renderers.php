<?php
class theme_fadeback_core_renderer extends core_renderer {

    public function heading($text, $level = 2, $classes = 'main', $id = null) {
 
 	if($level == 2) {
    $content  = html_writer::start_tag('div', array('class'=>'headingwrap'));
    $content .= parent::heading($text, $level, $classes, $id);
    }
   	else {
    $content  = parent::heading($text, $level, $classes, $id);
    }
    if($level == 2) {
    $content .= html_writer::end_tag('div');
    }
    return $content;
}
       
      function block(block_contents $bc, $region) {
        $bc = clone($bc); // Avoid messing up the object passed in.
        if (empty($bc->blockinstanceid) || !strip_tags($bc->title)) {
            $bc->collapsible = block_contents::NOT_HIDEABLE;
        }
        if ($bc->collapsible == block_contents::HIDDEN) {
            $bc->add_class('hidden');
        }
        if (!empty($bc->controls)) {
            $bc->add_class('block_with_controls');
        }
	
        //$bc->add_class('dock_on_load');

        $skiptitle = strip_tags($bc->title);
        if (empty($skiptitle)) {
            $output = '';
            $skipdest = '';
        } else {
            $output = html_writer::tag('a', get_string('skipa', 'access', $skiptitle), array('href' => '#sb-' . $bc->skipid, 'class' => 'skip-block'));
            $skipdest = html_writer::tag('span', '', array('id' => 'sb-' . $bc->skipid, 'class' => 'skip-block-to'));
        }
		$output .= html_writer::start_tag('div',array('class' => 'blockcont'));
		
        $output .= html_writer::start_tag('div', $bc->attributes);

        $output .= $this->block_header($bc);
        $output .= $this->block_content($bc);

        $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        $output .= $this->block_annotation($bc);

        $output .= $skipdest;

        $this->init_block_hider_js($bc);
        return $output;
    }
    
    

    //end class
 
}