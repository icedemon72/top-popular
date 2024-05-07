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

export const handleModal = (url, selectedClass = '.modalTrigger', id = 'deleteModal', form = 'deleteForm') => {
	document.querySelectorAll(selectedClass).forEach(function(element) {
		element.addEventListener('click', function() {
			let ID = this.dataset.trigger;
			url = url.replace(':id', ID);
			document.getElementById(form).setAttribute('action', url);
			let modal = document.getElementById(id);
			modal.className = modal.className.replace( /(?:^|\s)hidden(?!\S)/g , 'flex' );
		});
	});
	document.addEventListener('keydown', function (event) {
		event.key === 'Escape' && closeModal(id);
	});
}
export const closeModal = (id = 'deleteModal') => {
	let modal = document.getElementById(id);
	modal.className = modal.className.replace( /(?:^|\s)flex(?!\S)/g , 'hidden' );
}

export const sortTable = (selectedClass = '.sortable_th') => {
	document.querySelectorAll(selectedClass).forEach(function(element) {
		element.addEventListener('click', function() {
			let query = this.dataset.sort;
			let order = this.dataset?.order ? 'asc' : 'desc';
			if ('URLSearchParams' in window) {
				let searchParams = new URLSearchParams(window.location.search);
				let searched = searchParams.get('sort');
				if(searched?.split('_')[0] === query) {
					order = searched.split('_')[1] === 'asc' ? 'desc' : 'asc';
				}

				searchParams.set('sort', `${query}_${order}`);
				window.location.search = searchParams.toString();
			}
		});
	});
}

export const showChevron = () => {
	const searchParams = new URLSearchParams(window.location.search);
	let sort = searchParams.get('sort');
	
	if(sort && sort.includes('_')) {
		sort = sort.split('_');
		let query = sort[0];
		let order = sort[1];

		let chevrons = document.getElementById(query);
		chevrons.className.baseVal = chevrons.className.baseVal.replace( /(?:^|\s)block(?!\S)/g , 'hidden' );
	
		let chevron = document.getElementById(`${query}_${order}`);
		chevron.className.baseVal = chevron.className.baseVal.replace( /(?:^|\s)hidden(?!\S)/g , 'block' );

	}
}
