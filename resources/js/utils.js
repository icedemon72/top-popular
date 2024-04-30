export const giveLike = async (type = 'like', id, URL, CSRF, archived = 0, postType = 'post') =>  {
	if(archived == 0) {
		const response = await fetch(URL, {
			method: 'POST',
			body: JSON.stringify({ type }),
			headers: {
				"X-CSRF-Token": CSRF,
				"Content-Type": "application/json"
			},
		});
		if (response.redirected) {
			window.location.href = response.url;
	}
	
		const likesObj = await response.json();
	
		let likes = document.querySelector(`div#${postType}_${id} > div#${postType}_likes`);
		let likesCount = document.querySelector(`div#${postType}_${id} > #${postType}_likes_count`)
	
		let dislikes = document.querySelector(`div#${postType}_${id} > div#${postType}_dislikes`);
		let dislikesCount = document.querySelector(`div#${postType}_${id} > #${postType}_dislikes_count`);
	
		((likesObj.alreadyLiked || likesObj.switched) && likesObj.type === 'like') 
			? likes.classList.add('bg-main')
			: likes.classList.remove('bg-main');
	
		((likesObj.alreadyLiked || likesObj.switched) && likesObj.type === 'dislike')
			? dislikes.classList.add('bg-main')
			: dislikes.classList.remove('bg-main');
	
		likesCount.innerHTML = likesObj.likes;
		dislikesCount.innerHTML = likesObj.dislikes;
	}
}

export const handleModal = (url, selectedClass = '.modalTrigger') => {
	document.querySelectorAll(selectedClass).forEach(function(element) {
			element.addEventListener('click', function() {
					let ID = this.dataset.trigger;
					url = url.replace(':id', ID);
					document.getElementById('deleteForm').setAttribute('action', url);
					let deleteModal = document.getElementById('deleteModal');
					deleteModal.className = deleteModal.className.replace( /(?:^|\s)hidden(?!\S)/g , 'flex' )
		});
	});
}

export const closeModal = () => {
	deleteModal.className = deleteModal.className.replace
		( /(?:^|\s)flex(?!\S)/g , 'hidden' )
}