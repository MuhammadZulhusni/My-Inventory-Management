// Image preview functionality
document.getElementById('product_image').addEventListener('change', function(event) {
    const preview = document.getElementById('image-preview');
    const previewImage = document.getElementById('preview-image');
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.style.display = 'block';
            previewImage.setAttribute('src', e.target.result);
        }
        
        reader.readAsDataURL(this.files[0]);
    }
});

// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// SweetAlert for reset button
document.getElementById('reset-btn').addEventListener('click', function() {
    Swal.fire({
        title: 'Reset Form?',
        text: "All entered data will be cleared.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0068b7',
        cancelButtonColor: '#718096',
        confirmButtonText: 'Yes, reset it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Reset the form
            document.querySelector('form').reset();
            // Hide the image preview
            document.getElementById('image-preview').style.display = 'none';
            // Remove validation classes
            document.querySelector('form').classList.remove('was-validated');
            
            Swal.fire(
                'Reset!',
                'The form has been cleared.',
                'success'
            );
        }
    });
});