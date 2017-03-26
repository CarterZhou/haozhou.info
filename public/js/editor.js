jQuery(document).ready(function($) {
    $("#tags").select2({});
    tinymce.init({
        selector:'textarea',
        plugins: "codesample",
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | codesample'
    });
});