function getExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
}

function isDocument(filename) {
    var ext = getExtension(filename);
    switch (ext.toLowerCase()) {
        case 'txt':
        case 'pdf':
            return true;
    }
    return false;
}

$(function() {
    $('form').submit(function() {
        function failValidation(msg) {
            alert(msg);
            return false;
        }
        var file = $('#InputFile');
        if (!isDocument(file.val())) {
            return failValidation('Veuillez selectionner le bon type de fichier. Type de document autorisé : .txt');
        }
    });

});