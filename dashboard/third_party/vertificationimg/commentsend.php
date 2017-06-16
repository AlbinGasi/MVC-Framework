<?php
require_once '../../show_news_classic.php';
session_start();
if(isset($_POST['iw-btn-comment'])){
					$vfk = (!empty($_POST['iw-key'])) ? $_POST['iw-key'] : "";
					$name = strip_tags(trim($_POST['iw-name']));
					$comments = htmlentities(strip_tags(trim($_POST['iw-comments'])));
					$date = date('d.m.Y') . ' | ' . date('h:m:s');
					$post_id = $_POST['post_id'];
					
					$status = 1;
					
					if(empty($vfk)){
						$status = 0;
						$_SESSION['cs']['vfk'] = "Insert vertification code!";
					}else if(!is_numeric($vfk)){
						$status = 0;
						$_SESSION['cs']['vfk'] = "Use only numbers!";
					}

					if(empty($name)){
						$status = 0;
						$_SESSION['cs']['name'] = "Insert your name!";
					}else if(strlen($name)<3){
						$status = 0;
						$_SESSION['cs']['name'] = "Name is short!";
					}
					
					if(empty($comments)){
						$status = 0;
						$_SESSION['cs']['comments'] = "Insert your comment!";
					}else if(strlen($comments)<5){
						$status = 0;
						$_SESSION['cs']['comments'] = "Comment is short!";
					}

					if($status == 1){
						if(isset($_COOKIE['tntcon'])){
							if(md5($vfk).'a4xn' == $_COOKIE['tntcon']){
								$_SESSION['cs']['success'] = "You are successful commented";
								$insertComment = new EComments;
								$insertComment->insert_comment($name, $date, $post_id, $comments);
								header("Location:" . $_SERVER['HTTP_REFERER'] . "#iw-iw-comment");
							}else{
								$_SESSION['cs']['vfk'] = "Vertification code is wrong!";
								header("Location:" . $_SERVER['HTTP_REFERER'] . "#iw-iw-comment");
							}
						}
					}else{
						error_reporting(E_ALL);
						ini_set('display_errors','On');
						header("Location:" . $_SERVER['HTTP_REFERER'] . "#iw-iw-comment");
					}
				}

?>