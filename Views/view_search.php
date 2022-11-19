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
            <?php
            if(count($ListFiles) == 1){?>
                <h3><?php echo count($ListFiles);?> document a été trouvé pour le mot-clé : <?php echo $WorSearch;?></h3>
            <?php
            }else{?>
                <h3><?php echo count($ListFiles);?> documents ont été trouvé pour le mot-clé : <?php echo $WorSearch;?></h3>
            <?php }
            ?>
            
        <div class="row">
            <div class="col">
 
            <?php
            foreach ($ListFiles as $key => $value){?>
                <div class="row divStyle2">
                    <div class="col">
                        <u><h4><?php echo $value['Name'];?> :</h4></u>
                        <p><u>Description :</u> <?php echo $value['Description'];?></p>
                        <p><u>Type :</u> <?php if ($value['Type'] == "html"){echo "Site Web";}else{echo "Document";}?></p>

                        <a href="?controller=cloud&action=PageInfo&FileId=<?=$value["FileID"]?>" style="text-decoration:none;color: inherit;"><li class="list-group-item">Document : <strong><?=$value["Name"]?></strong></li></a>
                    </div>
                    <div class="col" style="text-align: center">
                        <?php
                        shuffle($ListeKeyWords[$value['FileID']]);
                        $MaxOccu = max(array_column($ListeKeyWords[$value['FileID']], 'Occurence'));
                        $MinOccu = min(array_column($ListeKeyWords[$value['FileID']], 'Occurence'));
                        $i=0;
                        foreach ($ListeKeyWords[$value['FileID']] as $key => $value) {
                            echo '<span id="foo" style="font-size:'.getSizeTags($MinOccu,$MaxOccu,$value["Occurence"]).'px;">&nbsp'.$value["Word"].'&nbsp;</span>';
                            $i++;
                            if($i%4==0){
                                echo '<br>';
                            }
                        }
                        ?>
                    </div>
                </div>
                
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