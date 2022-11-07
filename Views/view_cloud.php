<?php
require('view_begin.php');
?>


<div class="container">

    <div class="row DivData">
        <div class="col InfoFile">
            <div style="padding: 70px 0; text-align: center; margin-bottom: 6%; margin-top: 6%">
            <?php
            $typeAudio = ["mp3","wav","wma","aac","flac"];
            if (isset($Extension) and isset($PathFile)){
                if ($Extension==="txt"){?>
                        <center>
                            <object data="<?=$PathFile?>" width="80%" height=auto style="padding: 1em">
                                Not supported
                            </object>
                            <a href=<?=$PathFile?> class="btn btn-primary" download="<?=explode("/", $PathFile)[2]?>">Télécharger le document</a>
                        </center>
                        <?php
                }else{?>
                    <div style="padding: 20px;border: solid; border-radius: 30px;">
                    <center>
                        <iframe src="<?=$PathFile?>" width="400" height="200"></iframe>
                        <br>
                        <a href="<?=$PathFile?>" class="btn btn-primary" >Lien vers le site</a>
                    </center>
                    </div>
                    <?php

                }
            }

                if (isset($Name) and isset($Description)){
                ?>
                    <div class="videoSimi" style="overflow-wrap: break-word;">
                <p><u><strong>Nom :</strong></u> <?=$Name?></p>
                <p><u><strong>Description :</strong></u> <?=$Description?></p>
                    </div>
                <?php
                }
             ?>
            </div>
            </div>
            <div class="col" style="display: flex; align-items: center; justify-content: center;" >
                <div style="padding: 70px 0; text-align: center; margin-bottom: 6%; margin-top: 6%; border: solid; border-radius: 30px;">
                <!-- <u><h1>Nuage de mots :</h1></u> -->
                <?php
                if (isset($tabWord)){
                    shuffle($tabWord);
                    $MaxOccu = max(array_column($tabWord, 'Occurence'));
                    $MinOccu = min(array_column($tabWord, 'Occurence'));
                    $i=0;
                    foreach ($tabWord as $valueArray) {
                        echo '<span style="font-size:'.getSizeTags($MinOccu,$MaxOccu,$valueArray["Occurence"]).'px; display:inline">&nbsp'.$valueArray["Word"].'&nbsp;</span>';
                        $i++;
                        if($i%6==0){
                            echo '<br>';
                        }
                    }
                }
                ?>
                </div>
            </div>
        </div>
    <hr>

    </div>

</div>



<?php
require('view_end.php');
?>
