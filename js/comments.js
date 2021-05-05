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
	xhr.open('POST', '/api/comments/vote.php', true);
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

async function deleteComment(cid) {
	let response = await (await fetch('/api/comments/delete.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded'
		},
		body: `cid=${cid}`
	})).json();

	if(response.success) {
		document.querySelector(`[data-uid="${cid}"]`).remove();
	} else {
		alert('An error occurred deleting this comment');
		console.log('Error deleting comment: ' + response.error);
	}
}

async function autocomplete_users(substr) {
	let options_html = '';
	for(let data of await fetch_suggestions(substr))
		options_html += `<div class="option autocomplete-suggestion" data-username="${sanitize(data.username)}"><img class="profile-picture" src="${sanitize(data.user_image)}">${sanitize(data.username)}</div>`;
	let tray = document.querySelector('.user-mention-autocomplete-tray');
	tray.innerHTML = options_html;
	tray.next();
}

async function fetch_suggestions(substr) {
	let response = await (await fetch('/api/comments/user-autocomplete-suggestions.php', {
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

async function commentCallback(parent) {
	let elem = parent ? document.querySelector(`.comment[data-uid="${parent}"]`) : document.querySelector('#main-comment-panel');
	let replyFieldClone = elem.querySelector('.comment-reply-field').cloneNode(true); // clone nodes so changes made below aren't seen in the DOM
	replyFieldClone.querySelectorAll('.user-mention').forEach(mention => {
		mention.innerText = `@{ ${mention.innerText.substring(1)} }` // wrap all mentions in a @{ username } format - this makes it easier for the backend to parse out what is intended to be a mention
	});
	let commentText = replyFieldClone.innerText;
	let response = await (await comment(commentText, parent, elem.querySelector(`.allow-replies-input`).checked)).json();
	if(response.success) {
		let parser = document.createElement('div');
		parser.innerHTML = response.html;
		initCommentElem(parser.querySelector('.comment'));
		if(parent)
			elem.querySelector('.reply-tray').insertBefore(parser.querySelector('.comment'), elem.querySelector('.reply-tray').firstChild);
		else
			document.querySelector('.comment-tray').insertBefore(parser.querySelector('.comment'), document.querySelector('.comment-tray').firstChild);
		elem.querySelector('.comment-reply-field').innerHTML = '';
	} else {
		console.log('Error posting comment: ' + response.error);
		alert('An error occurred posting your comment');
	}
}

// send comment POST to server
function comment(text, parent, allowReplies) {
	return fetch('/includes/review-helper.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded'
		},
		body: `item_id=${encodeURIComponent(new URLSearchParams(window.location.search).get('id'))}&review=${encodeURIComponent(text)}${parent ? '&parentid=' + parent : ''}&allow-replies=${allowReplies}&review-submit=true`
		}
	);
}

// sets up all the events necessary to get the tagging users system working
// takes a .comment-reply-field input parameter (either in a comment or the bottom of the page)
function initMentionSystem(input) {
	input.addEventListener('input', evt => {
		if(input.innerText == '\n') {
			// fix for Firefox keeping <br/> element in field if user deletes all content
			input.innerHTML = ''
		}

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
}

// sets up all events for a comment element, such as click and hover events
function initCommentElem(elem) {
    if(1 /* PLACEHOLDER for if-replies-permitted */) {
		let mouseOverElem = false;
		let mouseOverReplyPanel = false;

		let replyPanel = elem.querySelector('.comment-reply-panel');
		let content = elem.querySelector('.comment-content');
		let input = elem.querySelector('.comment-reply-field');
		let controls = elem.querySelector('.comment-reply-panel-controls');

		initMentionSystem(input);

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

		// don't show reply controls once field is empty
		input.addEventListener('input', () => {
			if(input.innerText == '')
				hideReplyControls();
			else
				showReplyControls();
		})

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
}

// set up events for each comment
document.querySelectorAll('.comment').forEach(initCommentElem);

// set up events for comment field at bottom of page
let input = document.querySelector('#main-comment-field');
let controls = document.querySelector('#main-comment-panel-controls');
let showCommentControls = () => controls.classList.add('enabled');
let hideCommentControls = () => controls.classList.remove('enabled');

initMentionSystem(input);

input.addEventListener('input', () => {
	if(input.innerText == '')
		hideCommentControls();
	else
		showCommentControls();
});
input.addEventListener('blur', () => {
	if(!input.innerText)
		hideCommentControls();			
});