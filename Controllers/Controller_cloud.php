<?php

class Controller_cloud extends Controller{

    public function action_default(){
        echo "<script>alert(\"coucou\")</script>";
        $this->render('cloud');
    }


    public function action_PageInfo()
    {
        $m = Model::getModel();
        $infoFile = $m->getDocByID($_GET["FileId"]);//get les infos du doc via son ID

        if($infoFile["Type"] == "html"){
            $pathFile = $infoFile["Filename"];
        }else{
            $pathFile = "src/Upload/".$infoFile["Filename"];
        }

        $extension = pathinfo($pathFile, PATHINFO_EXTENSION);

        $arrayKeyWord = $m->getMot($_GET["FileId"]);//Recupere la liste de mots clés du document courant

        $this->render('cloud',['Name'=>$infoFile["Name"],'tabWord'=>$arrayKeyWord,'PathFile'=>$pathFile,'Description'=>$infoFile["Description"],'TranscriptFile'=>null,'Extension'=>$extension]);
    }
}

?>
