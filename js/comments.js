function upvote(uid) {
	let state = document.querySelector('[data-uid="' + uid + '"]').getAttribute('data-vote-state');
	if(state != 'upvote')
		send_vote(uid, 'upvote');
	else
		send_vote(uid, 'none');
}

function downvote(uid) {
	let state = document.querySelector('[data-uid="' + uid + '"]').getAttribute('data-vote-state');
	if(state != 'downvote')
		send_vote(uid, 'downvote');
	else
		send_vote(uid, 'none');
}

function send_vote(uid, vote) {
	let xhr = new XMLHttpRequest();
	xhr.open('POST', '/includes/vote-helper.php', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.responseType = 'json';
	xhr.onreadystatechange = function() {
		if(xhr.readyState === XMLHttpRequest.DONE) {
			ratingElem = document.querySelector('[data-uid="' + uid + '"]').querySelector('.rating');
			if(xhr.status === 200) {
				if(xhr.response.success) {
					ratingElem.innerHTML = xhr.response.rating;
					document.querySelector('[data-uid="' + uid + '"]').setAttribute('data-vote-state', vote);
				} else {
					ratingElem.innerHTML = 'err';
				}
			} else {
				ratingElem.innerHTML = 'err';
			}
		}
	}
	xhr.send(`cid=${uid}&vote=${vote}`);
}

function report(uid) {
	let xhr = new XMLHttpRequest();
	xhr.open('POST', '/includes/report-helper.php', true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.responseType = 'json';
	xhr.onreadystatechange = function() {
		if(xhr.readyState === XMLHttpRequest.DONE) {
			if(xhr.status === 200) {
				if(xhr.response.success) {
					alert('Comment reported\n(Todo: replace this alert with something that looks a bit better)');
				} else {
					console.log('Error reporting comment: ' +  xhr.response.error)
				}
			} else {
				console.log('Error reporting comment: status code not 200');
			}
		}
	}
	xhr.send(`cid=${uid}`);
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