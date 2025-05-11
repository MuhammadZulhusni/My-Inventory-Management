function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview-image');
    const container = document.getElementById('preview-container');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        container.style.display = 'none';
        preview.src = '';
    }
}