function upvote(uid) {
	document.querySelector('[data-uid="' + uid + '"]').querySelector('.rating').innerHTML++;
	// make request to server eventually
}

function downvote(uid) {
	document.querySelector('[data-uid="' + uid + '"]').querySelector('.rating').innerHTML--;
	// make request to server eventually
}

document.querySelectorAll('.comment').forEach(function(elem) {
    if(1 /* PLACEHOLDER for if-replies-permitted */) {
		let mouseOverElem = false;
		let mouseOverReplyPanel = false;

		let replyPanel = elem.querySelector('.comment-reply-panel');
		let content = elem.querySelector('.comment-content');
		let input = elem.querySelector('.comment-reply-field');
		let controls = elem.querySelector('.comment-reply-panel-controls');

		let showReplyField = () => replyPanel.classList.add('enabled');
		let hideReplyField = () => replyPanel.classList.remove('enabled');
		let showReplyControls = () => controls.classList.add('enabled');
		let hideReplyControls = () => controls.classList.remove('enabled');
		
		content.addEventListener('mouseover', showReplyField);
		content.addEventListener('mouseout', hideReplyField);
		
		content.addEventListener('mouseover', () => { mouseOverElem = true });
		content.addEventListener('mouseout', () => { mouseOverElem = false });
		replyPanel.addEventListener('mouseover', () => { mouseOverReplyPanel = true });
		replyPanel.addEventListener('mouseout', () => { mouseOverReplyPanel = false });
		
		input.addEventListener('focus', () => {
			content.removeEventListener('mouseout', hideReplyField);
			showReplyControls();
		});
		input.addEventListener('blur', () => {
			if(!input.value) {
				content.addEventListener('mouseout', hideReplyField);
				if(!mouseOverReplyPanel) {
					hideReplyControls();
				}
				if(!mouseOverElem) {
					hideReplyField();
				}			
			}
		});
		
		// just placeholder values for now
		let reply = function() {
			makeComment({
				uid: genUID(),
				author: 'placeholder_user',
				author_image: 'data:image/svg+xml,%3C%3Fxml%20version%3D%221.0%22%20encoding%3D%22UTF-8%22%20%3F%3E%0A%3Csvg%20width%3D%2240px%22%20height%3D%2240px%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20style%3D%22background-color%3A%20%23868686%22%3E%0A%3Ctext%20x%3D%2250%25%22%20y%3D%2230px%22%20style%3D%22text-anchor%3A%20middle%3B%20font-size%3A%202.1rem%3B%20font-weight%3A%20bold%22%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23313131%22%3E%3F%3C%2Ftext%3E%0A%3C%2Fsvg%3E',
				author_url: 'javascript:alert("this would take you to a profile page");void 0;',
				text: input.value,
				rating: 0,
				time: new Date().toLocaleTimeString([], { timeStyle: 'short' }),
				role: 'resident',
				parent: elem.getAttribute('data-uid'),
				replies_permitted: elem.querySelector('#allow-replies--' + data.uid).checked
			});
		}
		elem.querySelector('button').addEventListener('click', reply);
		
		input.addEventListener('input', () => { input.style.height = ''; input.style.height = input.scrollHeight + 'px'; }); // fix textarea height
	}
	
	let actionMenuLink = elem.querySelector('.user-action-menu-link');
	let actionMenu = elem.querySelector('.user-action-menu');
	let hideActionMenu = function() {
		actionMenu.classList.remove('enabled');
		document.body.removeEventListener('click', hideActionMenu);
	};
	let showActionMenu = function(e) {
		document.querySelectorAll('.user-action-menu').forEach(menu => menu.classList.remove('enabled'));
		actionMenu.classList.add('enabled');
		e.stopPropagation();
		document.body.addEventListener('click', hideActionMenu);
	};
	actionMenuLink.addEventListener('click', showActionMenu);
	actionMenu.addEventListener('mouseover', () => document.body.removeEventListener('click', hideActionMenu));
	actionMenu.addEventListener('mouseout', () => document.body.addEventListener('click', hideActionMenu));
});