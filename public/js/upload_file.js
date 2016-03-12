$(document).on('ready', function() {
    $("input[name='upload_file[]']").fileinput({
    	showCaption: false,
    	language: "zh-TW"
    });
});

$("input[name='upload_file[]']").on('fileuploaded', function(event, data, previewId, index) {
    var form = data.form, files = data.files, extra = data.extra,
        response = data.response, reader = data.reader;

    console.log('File uploaded triggered');
});