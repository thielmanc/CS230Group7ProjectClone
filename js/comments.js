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