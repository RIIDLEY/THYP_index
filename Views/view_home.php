<?php
require('view_begin.php');
?>
    <script type="text/javascript" src="src/Upload.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <div class="grandeDivData container">
    <u><h1>Formulaire d'upload :</h1></u>
    <form action = "?controller=upload&action=upload" method="post" enctype="multipart/form-data" style="display:inline;">

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

<?php
require('view_end.php');
?>
