window.addEventListener('load', function() {
	document.querySelectorAll('.options-tray').forEach(tray => {
		let focused = false;
		
		function indexOfFirstMatch(arr, matcher) {
			for(let i = 0; i < arr.length; i++)
				if(matcher(arr[i]))
					return i;
			return null;
		}
		
		tray.focus = function() {
			focused = true;
		}
		
		tray.unfocus = function() {
			focused = false;
		}
		
		tray.next = function() {
			let curr = indexOfFirstMatch(tray.children, elem => elem.classList.contains('selected')) ?? tray.children.length - 1;
			tray.children[curr].classList.remove('selected');
			tray.children[(curr + 1) % tray.children.length].classList.add('selected');			
		}
		
		tray.previous = function() {
			let curr = indexOfFirstMatch(tray.children, elem => elem.classList.contains('selected')) ?? 0;
			tray.children[curr].classList.remove('selected');
			tray.children[(curr + tray.children.length - 1) % tray.children.length].classList.add('selected');	
		}
		
		tray.selected = function() {
			return tray.querySelector('.selected');
		}
		
		
		window.addEventListener('keydown', evt => {
			if(focused) {
				if(evt.key == 'Down' || evt.key == 'ArrowDown') {
					tray.next();
					evt.preventDefault();
				} else if(evt.key == 'Up' || evt.key == 'ArrowUp') {
					tray.previous();
					evt.preventDefault();
				} else if(evt.key == 'Enter') {
					tray.dispatchEvent(new CustomEvent('selection', { detail: tray.selected() }));
					evt.preventDefault();
				}
			}
		})
		
		
		let registerOptionClickHandler = child => {
			child.addEventListener('click', function() {
				[...tray.children].forEach(elem => elem.classList.remove('selected'));
				child.classList.add('selected');
				tray.dispatchEvent(new CustomEvent('selection', { detail: child }));
			})
		}
		
		[...tray.children].forEach(elem => registerOptionClickHandler(elem));
		
		new MutationObserver(function(mutationList, _) {
			mutationList.forEach(mutation => {
				mutation.addedNodes.forEach(node => registerOptionClickHandler(node));
			})
		}).observe(tray, {
			childList: true
		});
	})
})