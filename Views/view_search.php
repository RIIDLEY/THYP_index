<?php
require('view_begin.php');
?>
    <script>
        var element = document.getElementById("home");//Modifie la navbar en fonction de la page actuel
        element.classList.add("active");

    </script>

    <center><h1>Gogle</h1></center>
    <div class="container">
        <div class="row">
            <div class="col DivTools">
                <form class="form-inline" action = "?controller=search&action=recherche" method="post" style="display: inline-block;">
                    <div class="input-group mb-3">
                    <input type="text" class="form-control" name="KeyWords" size="50" placeholder="Mot clés"/>
                    </div>
                    <div class="input-group-append">
                        <input type="submit" value="Chercher" class="btn btn-primary"/></form>
                    </div>

            </div>
        </div>
        <?php
        if (isset($ListFiles) and !empty($ListFiles)) {
            ?>
            <hr>
        <div class="row">
            <div class="col divStyle">
 
            <?php
            foreach ($ListFiles as $key => $value){?>
                <a href="?controller=cloud&action=PageInfo&FileId=<?=$value["FileID"]?>" target="_blank" style="text-decoration:none;color: inherit;"><li class="list-group-item">Document : <strong><?=$value["Name"]?></strong></li></a>
            <?php
            }
            ?>
            </div>
            <?php
        } ?>
        </div>
    </div>

<?php
require('view_end.php');
?>