<?php get_header('header',$this->title);

// <-- This code is only for Index method in any Controllers
if ($this->has_page_file == true) {
	if (isset($this->data)){
		$data = $this->data;
	}else{
		$data = null;
	}
	get_page($this->pageName,['model_name' => $this->model, 'data' => $data]);
} else if($this->has_page == true) {
	has_page_content($this->has_page,$this->page);
}
// End -->

get_footer('footer'); ?>