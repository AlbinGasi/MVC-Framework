<?php

$name = (isset($_GET['name'])) ? $_GET['name'] : 'none';

$obj = $this->blog->get_blog_name_json($name);

echo json_encode($obj);

?>