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
    } else {
        alert('An error occurred sending your message');
        console.log('Error while sending message: ' + response.error);
    }
}

window.addEventListener('load', () => {
    let input = document.getElementById('send-message-input');
    let fixinput = () => { input.style.height = '0px'; input.style.height = input.scrollHeight + parseInt(window.getComputedStyle(input)['padding-bottom']) + 'px'; }
    input.addEventListener('input', fixinput); // fix textarea height
    fixinput(); // fix on page load
})