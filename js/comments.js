function sanitize(str) {
	if(str == null) return str;
	return str.replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;').replaceAll('"', '&quot;').replaceAll("'", '&apos;');
}

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

async function autocomplete_users(substr) {
	let options_html = '';
	for(let data of await fetch_suggestions(substr))
		options_html += `<div class="option" data-username="${sanitize(data.username)}"><img class="profile-picture" src="${sanitize(data.user_image)}">${sanitize(data.username)}</div>`;
	document.querySelector('.user-mention-autocomplete-tray').innerHTML = options_html;
}

async function fetch_suggestions(substr) {
	let response = await (await fetch('/includes/user-autocomplete-suggestions.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded',
		},
		body: `substring=${substr}`,
	})).json();

	if(response.success) {
		return response.suggestions;
	} else {
		console.log('Error fetching suggestions: ' + response.error);
		return [];
	}
}

// set up events for each comment
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
			if(!input.innerText) {
				content.addEventListener('mouseout', hideReplyField);
				if(!mouseOverReplyPanel) {
					hideReplyControls();
				}
				if(!mouseOverElem) {
					hideReplyField();
				}			
			}
		});
		
		// -------- setup user mention and autocomplete system --------
		input.addEventListener('input', evt => {
			let range = window.getSelection().getRangeAt(0);
			let textNode = range.commonAncestorContainer; // the node being typed into
			let tray = document.querySelector('.user-mention-autocomplete-tray');

			function hide_tray() {
				tray.unfocus();
				tray.classList.remove('enabled');
				tray.removeEventListener('selection', tray.selectionCallback);
			}

			if(!textNode.parentElement.classList.contains('user-mention')) {
				// user is not typing into an existing user-mention element - create one if they type an @ symbol
				hide_tray();
				if(evt.data == '@') {
					let index = range.startOffset; // index of the @ sign in the node being typed in
					let userMentionNode = document.createElement('span');
					userMentionNode.classList.add('user-mention');
					userMentionNode.innerText = '@';
					range.insertNode(userMentionNode);
					
					// fix cursor position
					range.setStart(userMentionNode, 1);
					
					textNode.data = textNode.data.substring(0, index - 1); // remove @ sign typed by user
				}
			} else {
				// user is typing into a user-mention element - setup autocomplete events
				let userMentionElement = textNode.parentElement;
				
				function show_tray(userMentionElement) {
					tray.focus();
					tray.classList.add('enabled');
					
					// adjust positioning of tray
					let elemLeft = userMentionElement.getBoundingClientRect().left;
					let elemTop = userMentionElement.getBoundingClientRect().top;
					tray.style.left = (elemLeft + window.scrollX) + 'px';
					tray.style.top = (elemTop + window.scrollY + 24) + 'px';


					tray.removeEventListener('selection', tray.selectionCallback);
					tray.selectionCallback = evt => {
						let autospace = document.createTextNode(' '); // automatically insert space and bring cursor out of user-mention node when user makes choice from suggestions
						userMentionElement.parentNode.insertBefore(autospace, userMentionElement.nextSibling);
						range.setStart(autospace, 1);
						userMentionElement.innerText = '@' + evt.detail.getAttribute('data-username');
						hide_tray();
					}
					tray.addEventListener('selection', tray.selectionCallback)
				}
				
				show_tray(userMentionElement);
				autocomplete_users(textNode.data.substring(1)); // remove @ sign from username when autocompleting
				
				// if user enters whitespace, exit user-mention element
				if(evt.inputType == 'insertLineBreak' || evt.inputType == 'insertParagraph' || evt.data == ' ') {
					hide_tray();
					let index = range.startOffset; // index of last char typed
					let remaining = textNode.data.substring(index - 1); // part of user-mention element being separated, if any
					textNode.data = textNode.data.substring(0, index - 1);
					
					// insert rest of username after user-mention element
					let remainingTextNode = document.createTextNode(remaining);
					userMentionElement.parentNode.insertBefore(remainingTextNode, userMentionElement.nextSibling);
					
					// fix cursor position
					range.setStart(remainingTextNode, 1);
					
					// edge case - stop highlighting if username is now empty
					if(userMentionElement.innerText == '@') {
						userMentionElement.classList.remove('user-mention');
					}
				}
			}
		});
		// -------- finish setup user mention and autocomplete system --------

		input.addEventListener('input', () => elem.querySelector('.review-hidden-input').value = input.innerText)

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


// set up events for comment field at bottom of page
let input = document.querySelector('#main-comment-field');
let controls = document.querySelector('#main-comment-panel-controls');
let showCommentControls = () => controls.classList.add('enabled');
let hideCommentControls = () => controls.classList.remove('enabled');

input.addEventListener('focus', () => {
	showCommentControls();
});
input.addEventListener('blur', () => {
	if(!input.innerText)
		hideCommentControls();			
});