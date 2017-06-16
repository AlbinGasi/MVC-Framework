<?php

if(!Admin::can_view_2()){
	Alerts::get_alert("danger","You can't change category");
	return false;
}

if(isset($_POST['id'])){
	if(!is_numeric($_POST['id'])){
		echo '<div class="alert alert-danger">
                    <strong>Sorry!</strong> Your request is invalid.
                </div>';
		return false;
	}
	$id = trim(strip_tags($_POST['id']));
	$category = Categories_edit::get_by_id($id);

	echo '<h3>Edit category</h3>';
	echo '<div id="form-group-edit-category" class="form-group">';
	echo '<input type="hidden" id="input-edit-category-id" value="'.$category->category_id.'">';
	echo '<input id="input-edit-category" class="form-control" name="update_category_name" value="'.$category->category_name2.'">';
	echo '</div>';

}else if(isset($_POST['catid']) && isset($_POST['name'])){
	$id = trim(strip_tags($_POST['catid']));
	$name = trim(strip_tags($_POST['name']));
	$category_f = Posts::set_categoryName($name);
	$edit_category = new Categories_edit;
	$edit_category->category_name = $category_f;
	$edit_category->category_name2 = $name;
	
	
	if(Validation::category_validate($edit_category->category_name)){
		$edit_category->update($id);
		Alerts::get_alert("success","Success","Category has been updated.");
	}else{
		Validation::get_error();
	}
	
}


?>