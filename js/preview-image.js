function previewImage(event) {
    const imgElement = document.getElementById('img');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imgElement.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}