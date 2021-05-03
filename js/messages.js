async function sendMessage(cid) {
    let response = await (await fetch('/api/messages/send.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `recipient=${cid}&message=${encodeURIComponent(document.getElementById('send-message-input').value)}`
    })).json()

    if(response.success) {
        let parser = document.createElement('div');
        parser.innerHTML = response.html;
        let elem = parser.firstElementChild;
        document.querySelector('.messages-section').appendChild(elem);

        scrollToMostRecent();
    } else {
        alert('An error occurred sending your message');
        console.log('Error while sending message: ' + response.error);
    }
}

function scrollToMostRecent() {
    // scroll to bottom of messages
    document.querySelector('.messages-section').scrollTop = document.querySelector('.messages-section').scrollHeight;
}

window.addEventListener('load', () => {
    let input = document.getElementById('send-message-input');
    let fixinput = () => { input.style.height = '0px'; input.style.height = input.scrollHeight + parseInt(window.getComputedStyle(input)['padding-bottom']) + 'px'; }
    input.addEventListener('input', fixinput); // fix textarea height
    input.addEventListener('input', scrollToMostRecent); // fix textarea pushing messages up when typing

    // fix on page load
    fixinput();
    scrollToMostRecent();

    // periodically update messages
    window.setInterval(async function() {
        let response = await (await fetch('/api/messages/fetch-unread.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `sender=${encodeURIComponent(new URLSearchParams(window.location.search).get('user'))}`
        })).json()

        if(response.success) {
            let parser = document.createElement('div');
            parser.innerHTML = response['message-html'];
            for(let message of parser.children)
                document.querySelector('.messages-section').appendChild(message.cloneNode(true));

            // scroll to bottom of messages if new ones were received
            if(response.count > 0)
                scrollToMostRecent();

            // set conversation card html
            document.querySelector('.conversations-panel').innerHTML = response['card-html'];
        } else {
            console.log('An error occurred during async message update: ' + response.error);
        }

    }, 2000);
})