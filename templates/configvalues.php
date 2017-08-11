<?php
use \lib\models\Config;
echo '<input type="hidden" id="site_url" value="'.Config::SITE_URL.'">';

define('SITE_URL', Config::SITE_URL);
define('IMAGES_DIR', Config::SITE_URL.'/public/images/');

?>

<script type="text/javascript">
	var site_url = $("#site_url").val();

</script>