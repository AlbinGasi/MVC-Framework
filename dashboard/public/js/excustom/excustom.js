function setNewTitle(){
	var setTitle = document.getElementById('postTitleName').value;
	var title = document.getElementsByTagName('title')[0];
	title.innerHTML = setTitle+' | '+title.innerHTML;
}