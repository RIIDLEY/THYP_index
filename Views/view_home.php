<?php
require('view_begin.php');
?>
    <script>
        var element = document.getElementById("upload");//Modifie la navbar en fonction de la page actuel
        element.classList.add("active");

    </script>
    <script type="text/javascript" src="src/Upload.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <div class="grandeDivData container">
    <u><h1>Formulaire d'upload de document :</h1></u>
    <form action = "?controller=home&action=upload" method="post" enctype="multipart/form-data" style="display:inline;">

        <div class="row" style="padding: 2%">
            <div class="col-md-6">
                <input type="text" class="form-control" name="Name" placeholder="Nom du document" maxLength="50" required>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" name="Description" placeholder="Description" maxLength="120" required>
            </div>
        </div>
        <div class="row" style="padding: 2%">
            <div class="col-md-6">
                <input id="InputFile" type="file" class="form-control-file" name="fichier" accept=".txt,.pdf">
            </div>
			<div class="col-md-6">
				<input type="submit" class="btn btn-primary btn-lg" value="Envoyer"/>
            </div>
        </div>
    </form>
    </div>
    <hr>

    <div class="grandeDivData container">
    <!-- https://riidley.github.io/tmp_html/index.html -->
    <u><h1>Formulaire d'indexation de site :</h1></u>
    <form action = "?controller=home&action=upload_URL" method="post" enctype="multipart/form-data" style="display:inline;">

        <div class="row" style="padding: 2%">
            <div class="col-md-6">
                <input type="url" class="form-control" name="URL" placeholder="URL" pattern="https://.*" maxLength="50" required>
            </div>
            <div class="col-md-6">
				<input type="submit" class="btn btn-primary btn-lg" value="Envoyer"/>
            </div>

        </div>
    </form>

    </div>

    <hr>

    <div class="grandeDivData container">
    <a class="btn btn-primary btn-lg" href="?controller=home&action=clearAllTable">Nettoyer les tables</a>
    <a class="btn btn-primary btn-lg" href="?controller=home&action=lectureFolder">Scan</a>
    </div>

<?php
require('view_end.php');
?>
