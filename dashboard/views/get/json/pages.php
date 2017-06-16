<?php
$pageName = (isset($_GET['pagename'])) ? trim($_GET['pagename']) : '';
$obj = $this->blog->get_page_json($pageName);

echo json_encode($obj);

?>