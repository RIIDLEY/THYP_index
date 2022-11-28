<?php
require('view_begin.php');
?>
    <script>
        var element = document.getElementById("home");//Modifie la navbar en fonction de la page actuel
        element.classList.add("active");

        function showHide(id) {
            var el = document.getElementById(id);
            if( el && el.style.display == 'block')    
                el.style.display = 'none';
            else 
                 el.style.display = 'block';
            }

        function chargement() {//Set le bouton de chargement
            var element = document.getElementById("buttonSubmit");
            element.style.display = 'none';

            var element = document.getElementById("buttonLoad");
            element.style.display = 'inline';
        }
    </script>


    <center><h1>Gogle <img src="src/css/loupe.png"  width="40"></h1></center>
    <div class="container">
        <div class="row">
            <div class="col DivTools">
                <form class="form-inline" action = "?controller=search&action=recherche" method="post" style="display: inline-block;">
                    <div class="input-group mb-3">
                    <input type="text" class="form-control" name="KeyWords" size="50" placeholder="Mot clés" <?php if (isset($WorSearch)){echo 'value="'.$WorSearch.'"';}?>/>
                    </div>
                    <div class="input-group-append">
                        <input type="submit" value="Chercher" id="buttonSubmit" onclick="chargement()" class="btn btn-primary"/></form>
                        <button class="btn btn-primary" id="buttonLoad" type="button" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="sr-only">Chargement</span>
                        </button>
                    </div>

            </div>
        </div>
        <?php
        if (isset($ListFiles) and !empty($ListFiles)) {
            ?>
            <hr>
            <?php
            if(count($ListFiles) == 1){?>
                <h5><?php echo count($ListFiles);?> document a été trouvé pour le mot-clé : <?php echo $WorSearch;?></h5>
            <?php
            }else{?>
                <h5><?php echo count($ListFiles);?> documents ont été trouvé pour le mot-clé : <?php echo $WorSearch;?></h5>
            <?php }
            ?>
            
        <div class="row">
            <div class="col">
 
            <?php
            foreach ($ListFiles as $key => $value){?>
                <div class="row divStyle2">
                    <div class="col" style="padding: 30px;">
                        <!-- <a <?php if ($value['Type'] == "html"){echo "href=\"".$value['Filename']."\"";}else{echo "href=\"src/Upload/".$value['Filename']."\"";}?>><?php echo $value['Name'];?></a>  -->
                        <h4><a <?php if ($value['Type'] == "html"){echo "href=\"".$value['Filename']."\"";}else{echo "href=\"src/Upload/".$value['Filename']."\"";}?>><?php echo $value['Name'];?></a>    <a class="btn btn-primary" onclick="showHide('<?php echo $value['FileID'];?>')"> <img src="src/css/nuage.png"  width="25" > </a></h4>
                        <p><?php echo $value['Description'];?></p>
                        <!-- <p><u>Type :</u> <?php if ($value['Type'] == "html"){echo "Site Web";}else{echo "Document";}?></p> -->
                        <!-- <a class="btn btn-primary" <?php if ($value['Type'] == "html"){echo "href=\"".$value['Filename']."\"";}else{echo "href=\"src/Upload/".$value['Filename']."\"";}?>>Document</a> -->
                    </div>
                    <div class="col" id="<?php echo $value['FileID'];?>" style="text-align: center; display: none; border-left: 4px solid white; border-top-left-radius: 80px; background: #D7DBE3; border-bottom-left-radius: 80px;">
                        <?php
                        shuffle($ListeKeyWords[$value['FileID']]);
                        $MaxOccu = max(array_column($ListeKeyWords[$value['FileID']], 'Occurence'));
                        $MinOccu = min(array_column($ListeKeyWords[$value['FileID']], 'Occurence'));
                        $i=0;
                        foreach ($ListeKeyWords[$value['FileID']] as $key => $value) {
                            echo '<span id="foo" style="font-size:'.getSizeTags($MinOccu,$MaxOccu,$value["Occurence"]).'px; color : '.getRandomColor().'">&nbsp'.$value["Word"].'&nbsp;</span>';
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