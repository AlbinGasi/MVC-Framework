<?php

$obj = $this->blog->get_blog_json('all');

echo json_encode($obj);

?>