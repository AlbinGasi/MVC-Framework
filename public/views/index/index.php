<?php get_header('header',$this->title);


if ($this->has_page_file == true) {
	get_page($this->pageName,$this->model);
} else if($this->has_page == true) {
	has_page_content($this->has_page,$this->page);
}



get_footer('footer'); ?>