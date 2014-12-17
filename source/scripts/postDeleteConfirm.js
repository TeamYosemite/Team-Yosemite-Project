function confirmDelete(id){
	var check = confirm('Delete post?');
	
	if (check) {
		window.location = 'post_delete.php?id=' + id
	}
}