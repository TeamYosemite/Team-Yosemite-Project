function confirmDelete(id){
	var check = confirm('Delete user?');
	
	if (check) {
		window.location = 'user_delete.php?id=' + id
	}
}