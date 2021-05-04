window.addEventListener('load', evt => {
    let tray = document.querySelector('.notification-tray');
    let showHideNotificationBubble = () => {
        if(tray.children.length == 0) {
            document.querySelector('.notification-alert-circle').classList.remove('enabled');
            document.querySelector('.notification-count').classList.remove('enabled');
        } else {
            document.querySelector('.notification-alert-circle').classList.add('enabled');
            document.querySelector('.notification-count').classList.add('enabled');
        }
    }
    showHideNotificationBubble();

    document.body.addEventListener('click', () => tray.classList.remove('enabled'));
    tray.addEventListener('mouseover', () => document.body.removeEventListener('click', hideTray));
    tray.addEventListener('mouseout', () => document.body.addEventListener('click', hideTray));

    document.querySelector('.notification-bell').addEventListener('click', evt => {
        tray.classList.add('enabled');
        evt.stopPropagation();
    });

    window.setInterval(async function() {
        let response = await (await fetch('/api/notifications/fetch-unread.php', {
            method: 'POST'
        })).json()

        if(response.success) {
            tray.innerHTML = response.html;
            document.querySelector('.notification-count').innerHTML = response.count;
            showHideNotificationBubble();
        } else {
            console.log('An error occurred during async notification update: ' + response.error);
        }
    }, 2000);
})