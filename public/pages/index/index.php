This is index page
<br>
<br>

<?php

/*
	Data from your model. In this case model name is depends on page name
 	Or if the model can't be found system automatically give name 'Index'
 */ 

// You can call method on this way
echo $model['model_name']->message();

// Get data from your controller
echo '<h3>' . $model['data']['name'] . '</h3>';
echo '<h3>' . $model['data']['age'] . '</h3>';

?>