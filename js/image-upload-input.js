window.addEventListener('load', evt => {
    document.querySelectorAll('.image-upload-input').forEach(input => {
        let previewImgElem = document.getElementById(input.getAttribute('data-preview-elem'));
        previewImgElem.addEventListener('click', evt => {
            input.click();
        });
    
        // update preview image element with new image
        input.addEventListener('change', evt => {
            if (input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImgElem.setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        })
    })
})