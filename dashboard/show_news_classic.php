<?php
require_once 'core/exinit.php';

class EGallery
{
	private static $_db;
	
	public static function Init(){
		self::$_db = EConnection::get_instance();
	}
	
	public function gallery_set($id){
		$stmt = self::$_db->prepare("SELECT ".EConfig::get('table_prefix')."gallery.post_id FROM ".EConfig::get('table_prefix')."gallery INNER JOIN ".EConfig::get('table_prefix')."posts ON ".EConfig::get('table_prefix')."gallery.post_id=".EConfig::get('table_prefix')."posts.post_id WHERE ".EConfig::get('table_prefix')."posts.post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		if($stmt->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function get_gallery_image_name($id){
		$stmt = self::$_db->prepare("SELECT ".EConfig::get('table_prefix')."gallery.gallery_value FROM ".EConfig::get('table_prefix')."gallery INNER JOIN ".EConfig::get('table_prefix')."posts ON ".EConfig::get('table_prefix')."gallery.post_id=".EConfig::get('table_prefix')."posts.post_id WHERE ".EConfig::get('table_prefix')."posts.post_id=? ORDER BY ".EConfig::get('table_prefix')."gallery.gallery_id DESC;");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
}
Egallery::Init();


class EComments
{
	private static $_db;
	
	public static function Init(){
		self::$_db = EConnection::get_instance();
	}
	
	public function insert_comment($author,$comment_date2,$post_id,$comment){
		$stmt = self::$_db->prepare("INSERT INTO ".EConfig::get('table_prefix')."comments (comment_author,comment_date2,post_id,comment) VALUES (?,?,?,?)");
		$stmt->bindValue(1, $author);
		$stmt->bindValue(2, $comment_date2);
		$stmt->bindValue(3, $post_id);
		$stmt->bindValue(4, $comment);
		$stmt->execute();
	}
	
	public static function get_postCommentCount($post_id){
		$stmt = self::$_db->prepare("SELECT comment_id FROM ".EConfig::get('table_prefix')."comments INNER JOIN ".EConfig::get('table_prefix')."posts on ".EConfig::get('table_prefix')."comments.post_id=".EConfig::get('table_prefix')."posts.post_id WHERE ".EConfig::get('table_prefix')."posts.post_id=:id ORDER BY ".EConfig::get('table_prefix')."comments.comment_id DESC");
		$stmt->bindValue(":id",$post_id);
		$stmt->execute();
		$res = $stmt->rowCount();
		return $res;
	}
	
	public function get_postComment($post_id){
		$stmt = self::$_db->prepare("SELECT * FROM ".EConfig::get('table_prefix')."comments INNER JOIN ".EConfig::get('table_prefix')."posts on ".EConfig::get('table_prefix')."comments.post_id=".EConfig::get('table_prefix')."posts.post_id WHERE ".EConfig::get('table_prefix')."posts.post_id=:id ORDER BY ".EConfig::get('table_prefix')."comments.comment_id DESC");
		$stmt->bindValue(":id",$post_id);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public function render_postComment($post_id){
		$comments = $this->get_postComment($post_id);
		
		$output = "";
		$output .= '<div class="iw-all-comments">';
		foreach ($comments as $comment){
			$output .= '<div class="iw-self-comment" id="'.$comment['comment_id'].'">';
			$output .= '<div class="iw-comment-author">';
			$output .= '<p>'.$comment['comment_author'].'</p>';
			$output .= '<p>'.$comment['comment_date2'].'</p>';
			$output .= '</div>';
			$output .= '<div class="iw-comment-content">';
			$output .= '<p>'.$comment['comment'].'</p>';
			$output .= '</div></div>';
		}
		$output .= '</div>';
		return $output;
	}
	
	public function show_postComment($post_id){
		return $this->render_postComment($post_id);
	}
	
	
}
EComments::Init();


class Eposts
{
	private static $_db;
	private $_galleryStyle = "modern";

	public static function Init(){
		self::$_db = EConnection::get_instance();
	}
	
	public function if_more_than10($str,$length=null){
		if($length==null){
			$comm = "";
			for($i=0;$i<strlen($str);$i++){
				if($i<20){
					$comm .= $str[$i];
				}else if($i>20 && $i<25){
					$comm .= ".";
				}
			}
			return $comm;
		}else{
			$comm = "";
			for($i=0;$i<strlen($str);$i++){
				if($i<$length){
					$comm .= $str[$i];
				}else if($i>$length && $i<$length+4){
					$comm .= ".";
				}
			}
			return $comm;
		}
	}
	
	public function include_style(){
		return '<link rel="stylesheet" type="text/css" href="'.EConfig::get('folder_name').'/public/css/excustom/style.css">';
	}
	
	/*
	 	 **************************** SET [ --- ]
	*/
	
	public function set_galleryStyle($type){
		$this->_galleryStyle = $type;
	}
	
	public function set_title($titleName){
		$output = "";
		$output .= "<input type='hidden' value='".$titleName."' id='postTitleName'>";
		$output .= "<script>
					var setTitle = document.getElementById('postTitleName').value;
					var title = document.getElementsByTagName('title')[0];
					title.innerHTML = setTitle+' | '+title.innerHTML;</script>";
		return $output;
	}
	
	public function set_style($stylePath){
		return '<link rel="stylesheet" href="'.EConfig::get('folder_name').'/'.$stylePath.'" type="text/css" media="screen" />';
	}
	public function set_script($scriptPath){
		return '<script src="'.EConfig::get('folder_name').'/'.$scriptPath.'" type="text/javascript"></script>';
	}
	
	public function set_galleryImage($photoName){
		return '<a href="'.EConfig::get('folder_name').'/'.EConfig::get('gallery_dir').$photoName.'" rel="lightbox-cats"><img class="wp-gallery22" src="'.EConfig::get('folder_name').'/'.EConfig::get('gallery_dir').$photoName.'"></a>';
	}
	
	public function set_galleryImage2($photoName){
		return '<img alt="" src="'.EConfig::get('folder_name').'/'.EConfig::get('gallery_dir').$photoName.'" data-image="'.EConfig::get('folder_name').'/'.EConfig::get('gallery_dir').$photoName.'" data-description="">';
	}
	
	
	
	
	/*
		 ********************** GET [prepare query for render] 
	*/
	
	public function get_post_date($id){
		$stmt = self::$_db->prepare("SELECT post_date FROM ".EConfig::get('table_prefix')."posts WHERE post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$res['post_date'];
	
		$_date = $res['post_date'];
		$_date = explode(" ",$_date);
		$date = $_date[0];
		$date = explode("-",$date);
		$d = $date[2];
		$m = $date[1];
		$y = $date[0];
	
		$complete_date = $d . "." . $m . "." . $y;
	
		return $complete_date;
	}
	
	public function get_post_time($id){
		$stmt = self::$_db->prepare("SELECT post_date FROM ".EConfig::get('table_prefix')."posts WHERE post_id=?");
		$stmt->bindValue(1,$id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$res['post_date'];
	
		$_time = $res['post_date'];
		$_time = explode(" ",$_time);
		$time = $_time[1];
		$time = explode(":",$time);
		$h = $time[0];
		$m = $time[1];
	
		$complete_time = $h . ":" . $m;
		return $complete_time;
	
	}
	
	public function get_postCategory($post_id){
		$stmt = self::$_db->prepare("SELECT ".EConfig::get('table_prefix')."categories.category_name2 from ".EConfig::get('table_prefix')."categories JOIN ".EConfig::get('table_prefix')."post_category ON ".EConfig::get('table_prefix')."categories.category_id=".EConfig::get('table_prefix')."post_category.category_id WHERE ".EConfig::get('table_prefix')."post_category.post_id=?");
		$stmt->bindValue(1,$post_id);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$text = "";
		foreach ($res as $r){
			$text .= $r['category_name2'] . " | ";
		}
		
		$text = trim($text,' | ');
		return $text;
	}
	
	public function get_allPosts(){
		$stmt = self::$_db->query("SELECT * FROM ".EConfig::get('table_prefix')."posts WHERE post_status='publish' and post_type='post' ORDER BY post_date DESC");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public function get_allPostsOfCategories($category,$newsNumber){
		$categoryUno = $category;
		$categoryUno = explode(",",$categoryUno);
		$category33 = "";
		foreach ($categoryUno as $cat){
			$category33 .= '\'' . $cat . '\'' . ",";
		}
		$category33 = trim($category33,",");
	
		$stmt = self::$_db->query("SELECT * FROM ".EConfig::get('table_prefix')."categories WHERE category_name2 in ({$category33})");
		if ($stmt->rowCount() > 0){
			$category1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$category_id = "";
			foreach ($category1 as $cat){
				$category_id .= $cat['category_id'] . ',';
			}
			$category_id = trim($category_id,",");
			if($newsNumber == "none"){
				$stmt2 = self::$_db->query("SELECT * FROM ".EConfig::get('table_prefix')."posts JOIN ".EConfig::get('table_prefix')."post_category ON ".EConfig::get('table_prefix')."posts.post_id=".EConfig::get('table_prefix')."post_category.post_id WHERE ".EConfig::get('table_prefix')."post_category.category_id in ({$category_id}) and ".EConfig::get('table_prefix')."posts.post_status='publish' and post_type='post' ORDER BY ".EConfig::get('table_prefix')."posts.post_date DESC");
			}else if(is_numeric($newsNumber)){
				$stmt2 = self::$_db->query("SELECT * FROM ".EConfig::get('table_prefix')."posts JOIN ".EConfig::get('table_prefix')."post_category ON ".EConfig::get('table_prefix')."posts.post_id=".EConfig::get('table_prefix')."post_category.post_id WHERE ".EConfig::get('table_prefix')."post_category.category_id in ({$category_id}) and ".EConfig::get('table_prefix')."posts.post_status='publish' and post_type='post' ORDER BY ".EConfig::get('table_prefix')."posts.post_date DESC LIMIT {$newsNumber}");
			}
			
			if($stmt2->rowCount() > 0){
				$res = $stmt2->fetchAll(PDO::FETCH_ASSOC);
				return $res;
			}else{
				return "nopost";
			}
	
		}else{
			return "none";
		}
	}
	
	public function get_postByName($postName){
		$stmt = self::$_db->prepare("SELECT * FROM ".EConfig::get('table_prefix')."posts WHERE post_status='publish' and post_type='post' and post_name=?");
		$stmt->bindValue(1, $postName);
		$stmt->execute();
		if($stmt->rowCount() == 1){
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			return $res;
		}else{
			return "none";
		}
	}
	
	public function get_categories(){
		$stmt = self::$_db->query("SELECT * FROM ".EConfig::get('table_prefix')."categories");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public function get_postByCategory($category){
		$stmt = self::$_db->prepare("SELECT * FROM ".EConfig::get('table_prefix')."categories WHERE category_name=?");
		$stmt->bindValue(1, $category);
		$stmt->execute();
		if ($stmt->rowCount() == 1){
			$category1 = $stmt->fetch(PDO::FETCH_ASSOC);
			$category_id = $category1['category_id'];
	
			$stmt2 = self::$_db->prepare("SELECT * FROM ".EConfig::get('table_prefix')."posts JOIN ".EConfig::get('table_prefix')."post_category ON ".EConfig::get('table_prefix')."posts.post_id=".EConfig::get('table_prefix')."post_category.post_id WHERE ".EConfig::get('table_prefix')."post_category.category_id=? and ".EConfig::get('table_prefix')."posts.post_status='publish' and post_type='post' ORDER BY ".EConfig::get('table_prefix')."posts.post_date DESC");
			$stmt2->bindValue(1, $category_id);
			$stmt2->execute();
			if($stmt2->rowCount() > 0){
				$res = $stmt2->fetchAll(PDO::FETCH_ASSOC);
				return $res;
			}else{
				return "nopost";
			}
				
		}else{
			return "none";
		}
	}

	public function get_categoryName2ByCategoryName($category){
		$stmt = self::$_db->query("SELECT category_name2 FROM ".EConfig::get('table_prefix')."categories WHERE category_name='{$category}'");
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['category_name2'];
	}
	
	public function get_lastPost($numberOfPosts){
		$stmt = self::$_db->query("SELECT post_title, post_name,post_status FROM ".EConfig::get('table_prefix')."posts WHERE post_status='publish' and post_type='post' ORDER BY post_date DESC LIMIT {$numberOfPosts}");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	public function get_lastComments($numberOfComments){
		$stmt = self::$_db->query("SELECT * FROM ".EConfig::get('table_prefix')."comments ORDER BY comment_id DESC LIMIT {$numberOfComments}");
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	public function get_postName($post_id){
		$stmt = self::$_db->prepare("SELECT post_name FROM ".EConfig::get('table_prefix')."posts WHERE post_id=?");
		$stmt->bindValue(1, $post_id);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return $res['post_name'];
	}
	
	/*
	 	********************  Prepare for use => 'render'
	*/
	
	public function render_postName($postName){
		$post = $this->get_postByName($postName);
		$output = "";
		if($post != "none"){
			$output .= $this->set_title($post['post_title']);
			$output .= '<div class="self-post-view">';
			$output .= '<div class="self-post-title"><h2>'.$post['post_title'].'</h2></div>';
			$output .= '<div class="self-post-title-border"></div>';
			$output .= '<div class="self-post-author">';
			$output .= '<p>'.ucfirst($post['post_author']).'</p>';
			$output .= '<p>'.$this->get_post_date($post['post_id']). ' | ' . $this->get_post_time($post['post_id']) . '</p>';
			$output .= '</div>';
			$output .= '<div class="self-post-description">'.html_entity_decode($post['post_introduction']).'</div>';
			
			$gallery = new EGallery();
			if($post['post_image'] != "none"){
					if($this->_galleryStyle == "basic"){
						$output .= '<div class="self-post-image"><img src="'.EConfig::get('folder_name').'/'.EConfig::get('image_dir').$post['post_image'].'"></div>';
					}else if(!$gallery->gallery_set($post['post_id'])){
						$output .= '<div class="self-post-image"><img src="'.EConfig::get('folder_name').'/'.EConfig::get('image_dir').$post['post_image'].'"></div>';
					}
			}

			if($gallery->gallery_set($post['post_id'])){
				if($this->_galleryStyle == "basic"){
					$output .= $this->set_script("third_party/jquery/jquery.js");
					$output .= $this->set_script("third_party/slimbox2/js/slimbox2.js");
					$output .= $this->set_style("third_party/slimbox2/css/slimbox2.css");
				}else if ($this->_galleryStyle == "modern"){
					$output .= $this->set_script("third_party/unitegallery-master/package/unitegallery/js/jquery-11.0.min.js");
					$output .= $this->set_script("third_party/unitegallery-master/package/unitegallery/js/unitegallery.js");
					$output .= $this->set_style("third_party/unitegallery-master/package/unitegallery/css/unite-gallery.css");
					$output .= $this->set_script("third_party/unitegallery-master/package/unitegallery/themes/compact/ug-theme-compact.js");
				}

				$all_images = $gallery->get_gallery_image_name($post['post_id']);
				
				if($this->_galleryStyle == "modern"){
					$output .= '<div id="gallery22" style="display:none;">';
				}
				foreach ($all_images as $images){
					if($this->_galleryStyle == "basic"){
						$output .= $this->set_galleryImage($images['gallery_value']);
					}else if ($this->_galleryStyle == "modern"){
						$output .= $this->set_galleryImage2($images['gallery_value']);
					}
				}
				if($this->_galleryStyle == "modern"){
					$output .= '</div>';
					$output .= '<script type="text/javascript">jQuery(document).ready(function(){jQuery("#gallery22").unitegallery();});</script>';
				}
			}
			
			$output .= '<div class="self-post-content">'.html_entity_decode($post['post_content']).'</div>';
			$output .= '</div>';
			$output .= '<div id="iw-iw-comment">';
			if($post['comment_status'] == 'open'){
				$output .= '<div class="iw-comments-main">';
				$output .= '<form action="'.EConfig::get('folder_name').'/third_party/vertificationimg/commentsend.php" method="POST">';
				$output .= '<input type="hidden" name="post_id" value="'.$post['post_id'].'">';
				$output .= '<div class="iw-comments">';
				$output .= '<input type="text" name="iw-name" id="iw-name" placeholder="Your name..">';
				$output .= '<textarea rows="5" name="iw-comments" id="iw-comments" placeholder="Type your comment.."></textarea>';
				$output .= '<div class="iw-security">';
				$output .= '<input type="text" name="iw-key" id="iw-key">';
				$output .= '<div class="iw-security-img">';
				$output .= '<img src="'.EConfig::get('folder_name'). '/third_party/vertificationimg/verificationimage.php'.'">';
				$output .= '</div></div>';
				$output .= '<button type="submit" name="iw-btn-comment" class="iw-send-btn">Comment</button>';
				
				if(isset($_SESSION['cs'])){
					foreach($_SESSION['cs'] as $msg){
						if($msg == "You are successful commented"){
							$output .= "<div class='iw-alerts iw-info iw-sm'>{$msg}</div>";
						}else{
							$output .= "<div class='iw-alerts iw-danger iw-sm'>{$msg}</div>";
						}
						
					}
					unset($_SESSION['cs']);
				}

				$output .= '</div></div>';
				
				
				$comments = new EComments;
				$output .= $comments->show_postComment($post['post_id']);
				
				
			}
			$output .= '</div>';
			return $output;
		}else{
			return "<div class='iw-alerts iw-danger'>Post doesn't exists</div>";
		}
	}

	public function render_postByCategory($category){
		$postByCategory = $this->get_postByCategory($category);
		$output = "";
		
		if ($postByCategory == "none"){
			return "<div class='iw-alerts iw-danger'>Category no exists!</div>";
		}else if ($postByCategory == "nopost"){
			return "<div class='iw-alerts iw-danger'>Category is empty!</div>";
		}else {
			$page       = ( isset( $_GET['pg'] ) ) ? $_GET['pg'] : 1;
			$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 2;
			$Paginator = new PaginatorPostCategory($category);
			$all_posts = $Paginator->getData($page,$category);
			if($all_posts == "ERROR"){
				return "<div class='iw-alerts iw-danger'>Not found!</div>";
			}else{
			
			$output .= $this->set_title(ucfirst($this->get_categoryName2ByCategoryName($category)));
			foreach ($all_posts->data as $post){
				if($post['post_image'] == "none"){
					$output .= "<div class='iw-news-main' style='height:100px;'>";
					$output .= '<div class="iw-news-category" style="left:5px">'.$this->get_postCategory($post['post_id']).'</div>';
					$output .= '<div class="iw-news-title" style="left:5px"><a href="'.EConfig::get("url_news").'?iw='.$post['post_name'].'">'.$post['post_title'].'</a></div>';
					$output .= '<div class="iw-news-time" style="left:5px">'.$this->get_post_date($post['post_id']). ' | ' . $this->get_post_time($post['post_id']) . '</div>';
					$output .= '<div class="iw-news-more"><a href="'.EConfig::get("url_news").'?iw='.$post['post_name'].'">Read more</a></div>';
					$output .= '</div>';
				}else{
					$output .= "<div class='iw-news-main'>";
					$output .= '<div class="iw-news-image"><img src="'.EConfig::get('folder_name').'/'.EConfig::get('image_dir').$post['post_image'].'"></div>';
					$output .= '<div class="iw-news-category">'.$this->get_postCategory($post['post_id']).'</div>';
					$output .= '<div class="iw-news-title"><a href="'.EConfig::get("url_news").'?iw='.$post['post_name'].'">'.$post['post_title'].'</a></div>';
					$output .= '<div class="iw-news-time">'.$this->get_post_date($post['post_id']). ' | ' . $this->get_post_time($post['post_id']) . '</div>';
					$output .= '<div class="iw-news-more"><a href="'.EConfig::get("url_news").'?iw='.$post['post_name'].'">Read more</a></div>';
					$output .= '</div>';
				}
			}
			$output .= '<div class="clear22"></div>';
			$output .= $Paginator->createLinks($links, "iw-pagination",$category);
			return $output;
			}
		}
	}
	
	public function render_allPosts(){
		#$all_posts = $this->get_allPosts();
		$page       = ( isset( $_GET['pg'] ) ) ? $_GET['pg'] : 1;
		$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 2;
		$Paginator = new Paginator("SELECT * FROM ".EConfig::get('table_prefix')."posts WHERE post_status='publish' and post_type='post' ORDER BY post_date DESC");
		$all_posts = $Paginator->getData($page);
		if($all_posts == "ERROR"){
			return "<div class='iw-alerts iw-danger'>Not found!</div>";
		}else{
		$output = "";
		foreach ($all_posts->data as $post){
			$output .= '<div class="iw-postindex-main">';
			if($post['post_image'] != "none"){
				$output .= '<a href="?iw='.$post['post_name'].'"><img src="'.EConfig::get('folder_name').'/'.EConfig::get('image_dir').$post['post_image'].'"></a>';
			}
			$output .= '<p class="details">'.$this->get_postCategory($post['post_id']).' | '.$this->get_post_date($post['post_id']).' | <a href="?iw='.$post['post_name'].'#iw-iw-comment">'.EComments::get_postCommentCount($post['post_id']).' Comments</a></p>';
			$output .= '<h2><a href="?iw='.$post['post_name'].'">'.$post['post_title'].'</a></h2>';
			if(strlen($post['post_content']) > strlen($post['post_introduction'])){
				$output .= html_entity_decode($this->if_more_than10($post['post_content'],250)).'<a href="?iw='.$post['post_name'].'"> Read More</a>';
			}else{
				$output .= html_entity_decode($this->if_more_than10($post['post_introduction'],250)).'<a href="?iw='.$post['post_name'].'"> Read More</a>';
			}
			$output .= '<div class="iw-break"></div>';
			$output .= '</div>';
		}

		$output .= $Paginator->createLinks($links, "iw-pagination");
		return $output;
		}
	}
	
	public function render_allPostsOfCategories($category,$categoryShowstyle,$paginationShow,$newsNumber){
		$postByCategory = $this->get_allPostsOfCategories($category,$newsNumber);
		$output = "";
		
		if ($postByCategory == "none"){
			return "<div class='iw-alerts iw-danger'>Category no exists!</div>";
		}else if ($postByCategory == "nopost"){
			return "<div class='iw-alerts iw-danger'>Category is empty!</div>";
		}else {
			if($paginationShow != "disable"){
				$page       = ( isset( $_GET['pg'] ) ) ? $_GET['pg'] : 1;
				$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 2;
				$Paginator = new PaginatorPostOfCategory($category);
				$all_posts = $Paginator->getData($page,$category);
			}else{
				$all_posts = new stdClass();
				$all_posts->data = $postByCategory;
			}
			
			if($all_posts == "ERROR"){
				return "<div class='iw-alerts iw-danger'>Not found!</div>";
			}else{
		
			$post_id = [];
			foreach ($all_posts->data as $post){
				if(in_array($post['post_id'], $post_id)){
					continue;
				}else{
					
				if($categoryShowstyle == "list"){
					if($post['post_image'] == "none"){
						$output .= "<div class='iw-news-main' style='height:100px;'>";
						$output .= '<div class="iw-news-category" style="left:5px">'.$this->get_postCategory($post['post_id']).'</div>';
						$output .= '<div class="iw-news-title" style="left:5px"><a href="'.EConfig::get("url_news").'?iw='.$post['post_name'].'">'.$post['post_title'].'</a></div>';
						$output .= '<div class="iw-news-time" style="left:5px">'.$this->get_post_date($post['post_id']). ' | ' . $this->get_post_time($post['post_id']) . '</div>';
						$output .= '<div class="iw-news-more"><a href="'.EConfig::get("url_news").'?iw='.$post['post_name'].'">Read more</a></div>';
						$output .= '</div>';
					}else{
						$output .= "<div class='iw-news-main'>";
						$output .= '<div class="iw-news-image"><img src="'.EConfig::get('folder_name').'/'.EConfig::get('image_dir').$post['post_image'].'"></div>';
						$output .= '<div class="iw-news-category">'.$this->get_postCategory($post['post_id']).'</div>';
						$output .= '<div class="iw-news-title"><a href="'.EConfig::get("url_news").'?iw='.$post['post_name'].'">'.$post['post_title'].'</a></div>';
						$output .= '<div class="iw-news-time">'.$this->get_post_date($post['post_id']). ' | ' . $this->get_post_time($post['post_id']) . '</div>';
						$output .= '<div class="iw-news-more"><a href="'.EConfig::get("url_news").'?iw='.$post['post_name'].'">Read more</a></div>';
						$output .= '</div>';
					}
				}else if($categoryShowstyle == "list-v2"){
					$output .= '<div class="iw-postindex-main">';
					if($post['post_image'] != "none"){
						$output .= '<a href="?iw='.$post['post_name'].'"><img src="'.EConfig::get('folder_name').'/'.EConfig::get('image_dir').$post['post_image'].'"></a>';
					}
					$output .= '<p class="details">'.$this->get_postCategory($post['post_id']).' | '.$this->get_post_date($post['post_id']).' | <a href="?iw='.$post['post_name'].'#iw-iw-comment">'.EComments::get_postCommentCount($post['post_id']).' Comments</a></p>';
					$output .= '<h2><a href="?iw='.$post['post_name'].'">'.$post['post_title'].'</a></h2>';
					$output .= html_entity_decode($this->if_more_than10($post['post_content'],250)).'<a href="?iw='.$post['post_name'].'"> Read More</a>';
					$output .= '<div class="iw-break"></div>';
					$output .= '</div>';
					
					
					
				}
				}
				$post_id[] .= $post['post_id'];
			}
			$output .= '<div class="clear22"></div>';
			if($paginationShow != "disable"){
				$output .= $Paginator->createLinks($links, "iw-pagination",$category);
			}
			return $output;
			}
		}
	}
	
	
	
	public function render_categories($headerName,$categoryNotShow){
		$allCategories = $this->get_categories();
		$output = "";
		$output .= '<div class="iw-categories-main">';
		$output .= '<div class="iw-categories-main-header"><span>'.$headerName.'</span></div>';
		$output .= '<div class="iw-categories">';
		$output .= '<ul>';
		if($categoryNotShow != "none"){
			$cat_not_show = explode(",",$categoryNotShow);
			foreach ($allCategories as $category) {
				if(in_array($category['category_id'],$cat_not_show)){
					continue;
				}else{
					$output .= "<li><a href='".EConfig::get('url_news')."?c=".$category['category_name']."'>".ucfirst($category['category_name2']) . "</a></li>";
				}
			}
		}else if ($categoryNotShow == "none"){
			foreach ($allCategories as $category) {
				$output .= "<li><a href='".EConfig::get('url_news')."?c=".$category['category_name']."'>".ucfirst($category['category_name2']) . "</a></li>";
			}
		}
		$output .= '</ul>';
		$output .= '</div></div>';
		return $output;
	}
	
	public function render_lastPosts($numberOfPosts,$headerName){
		$lastPosts = $this->get_lastPost($numberOfPosts);
		$output = "";
		$output .= '<div class="iw-lastPosts-main">';
		$output .= '<div class="iw-lastPosts-main-header"><span>'.$headerName.'</span></div>';
		$output .= '<div class="iw-lastPosts">';
		$output .= '<ul>';
		foreach ($lastPosts as $post_title) {
			$output .= "<li><a href='".EConfig::get('url_news')."?iw=".$post_title['post_name']."'>".ucfirst($post_title['post_title']) . "</a></li>";
		}
		$output .= '</ul>';
		$output .= '</div></div>';
		return $output;
	}

	public function render_lastComments($numberOfComments,$headerName){
		$lastComments = $this->get_lastComments($numberOfComments);
		$output = "";
		$output .= '<div class="iw-lastPosts-main">';
		$output .= '<div class="iw-lastPosts-main-header"><span>'.$headerName.'</span></div>';
		$output .= '<div class="iw-lastPosts">';
		$output .= '<ul>';
		foreach ($lastComments as $comment) {
			$postName = $this->get_postName($comment['post_id']);
			$output .= "<li><a href='".EConfig::get('url_news')."?iw=".$postName."#".$comment['comment_id']."'>".html_entity_decode($this->if_more_than10($comment['comment'],30)) . "</a></li>";
		}
		$output .= '</ul>';
		$output .= '</div></div>';
		return $output;
	}
	
	/*
		 ******************** Show me.. 
	*/
	
	public function show_news(){
		if(isset($_GET['c'])){
			echo $this->render_postByCategory($_GET['c']);
		}else if(isset($_GET['iw'])){
			echo $this->render_postName($_GET['iw']);
		}else{
			echo $this->render_allPosts();
		}
	}
	
	public function show_news_of_categories($category,$categoryShowstyle,$paginationShow,$newsNumber){
		if(isset($_GET['c'])){
			echo $this->render_postByCategory($_GET['c']);
		}else if(isset($_GET['iw'])){
			echo $this->render_postName($_GET['iw']);
		}else{
			echo $this->render_allPostsOfCategories($category,$categoryShowstyle,$paginationShow,$newsNumber);
		}
	}
	
	public function show_categories($headerName,$categoryNotShow){
		echo $this->render_categories($headerName,$categoryNotShow);
	}
	
	public function show_lastPosts($numberOfPosts,$headerName){
		echo $this->render_lastPosts($numberOfPosts,$headerName);
	}
	public function show_lastComments($numberOfComments,$headerName){
		echo $this->render_lastComments($numberOfComments,$headerName);
	}

}

Eposts::Init();

$iw_news = new Eposts;

function include_style(){
	global $iw_news;
	return $iw_news->include_style();
}

/*
 *  Use for showing news on your Page
 */

function  iw_gallery_type($type){
	global $iw_news;
	$iw_news->set_galleryStyle($type);
}

function iw_show_news(){
	echo include_style();
	global $iw_news;
	$iw_news->show_news();
}

function iw_show_news_of_categories($categories="none",$categoryShowstyle='list-v2',$paginationShow="enable",$newsNumber="none"){
	echo include_style();
	global $iw_news;
	$iw_news->show_news_of_categories($categories,$categoryShowstyle,$paginationShow,$newsNumber);
}

/*
 *  Use for widget on your Sidebar
 */
function iw_show_categories($headerName = 'Categories',$categoryNotShow="none"){
	echo include_style();
	global $iw_news;
	$iw_news->show_categories($headerName,$categoryNotShow);
}

function iw_show_lastPosts($numberOfPosts=7,$headerName="Last posts"){
	echo include_style();
	global $iw_news;
	$iw_news->show_lastPosts($numberOfPosts,$headerName);
}

function iw_show_lastComments($numberOfComments=7,$headerName="Last comments"){
	echo include_style();
	global $iw_news;
	$iw_news->show_lastComments($numberOfComments,$headerName);
}
?>