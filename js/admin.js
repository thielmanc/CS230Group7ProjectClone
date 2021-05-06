function fillGalleryUploader(rid) {
    document.getElementById('gallery-upload-address-input').value = document.querySelector(`[data-rid="${rid}"]`).getAttribute('data-address');
    document.getElementById('gallery-upload-descript-input').value = document.querySelector(`[data-rid="${rid}"]`).getAttribute('data-descript');
    window.location = "#uploader";
    discardRequest(rid);
}

async function discardRequest(rid) {
    let response = await (await fetch('/api/admin/discard-request.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `rid=${rid}`
    })).json()

    if(response.success) {
        document.querySelector(`[data-rid="${rid}"]`).remove();
    } else {
        console.log('An error occurred during async request removal: ' + response.error);
    }
}