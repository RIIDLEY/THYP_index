<?php

class Controller_home extends Controller{

  public function action_home(){
    $this->render('home');
}

  public function action_default(){//fonction appele par defaut par la page
    $this->action_home();
  }

  public function action_clearAllTable(){
    $m = Model::getModel();
    $m->clearTableIndex();
    //$m->clearTableDoc();
    $this->action_home();
  }

  public function action_upload(){

    if(!empty($_FILES['fichier'])) {
      $tmp_nom = $_FILES['fichier']['tmp_name'];

        $idrandom = str_replace(".","",uniqid('', true));
      if(move_uploaded_file($tmp_nom, 'src/Upload/'.$idrandom."_".stripAccents(str_replace(' ', '', $_FILES['fichier']['name'])))){//ajoute le fichier à dossier de stockage du serveur avec la suppression des espaces
              $m = Model::getModel();
              $filename = $idrandom."_".stripAccents(str_replace(' ', '', $_FILES['fichier']['name']));
              $tmp_infos = ['name'=>$_POST["Name"], 'description' =>$_POST["Description"], 'filename'=>$filename,'type'=>pathinfo($_FILES['fichier']['name'])['extension'], 'size'=>$_FILES['fichier']['size']];

              $IdDocu = $m->addDoc($tmp_infos);//ajoute le fichier à la BDD

              $extension = pathinfo("src/Upload/".$filename, PATHINFO_EXTENSION);
              $this->indexation("src/Upload/".$filename,$IdDocu,"Document",$extension);//fait l'indexation

              echo "<script>alert(\"Fichier bien upload\")</script>";
              $this->render('home');
      }else{
          echo "<script>alert(\"Une erreure c'est produite lors de l'upload\")</script>";
          $this->render('home');
      }

    }else{
      echo "<script>alert(\"Il manque des informations\")</script>";
      $this->render('home');
    }

 }

 public function action_upload_URL(){

  if(isset($_POST['URL'])) {
    $m = Model::getModel();
    $tmp_infos = ['name'=>get_title($_POST['URL']), 'description' =>get_description($_POST['URL']), 'filename'=>$_POST['URL'],'type'=>"html", 'size'=>"Null"];

    $IdDocu = $m->addDoc($tmp_infos);//ajoute le fichier à la BDD

    $this->indexation($_POST['URL'],$IdDocu,"Site","html");//fait l'indexation

    echo "<script>alert(\"Fichier bien upload\")</script>";
    $this->render('home');

  }

}

 public function explode_bis($texte, $separateurs){
  $tok =  strtok($texte, $separateurs);//separe la chaine en tableau par rapport aux separateurs
  $listemotvide = file_get_contents ("Utils/Liste_Mot_Vide.txt");//Sort le fichier de mot vide
  $separateurs2 =  "\n" ;
  $motvide = explode($separateurs2,$listemotvide);//met le fichier de mot vide sous forme de tableau
  
  $tab_tok=array();

  for ($i=0; $i < count($motvide); $i++) {//enleve les espaces present au tour des mots du fichier de mot vide
      $motvide[$i] = trim($motvide[$i]);
  }

  if(strlen($tok) > 2  && !in_array($tok,$motvide))$tab_tok[] = $tok;//Si la taille du mot est supérieur à 2 et qu'il est pas present dans le tableau de mot vide on le garde

  while ($tok !== false) {
      $tok = strtok($separateurs);
      if(strlen($tok) > 2  && !in_array($tok,$motvide))$tab_tok[] = $tok;//Si la taille du mot est supérieur à 2 et qu'il est pas present dans le tableau de mot vide on le garde
  }

  return $tab_tok;
}

 public function indexation($document, $IDDoc,$type,$PDF){
  $m = Model::getModel();

  $texte = stripAccents(file_get_contents_utf8($document));//lecture du fichier

  if($type == "Site"){
    $texte_head = get_title($document) . " " . get_description($document) . " " . get_keywords($document);
    $text_head = $this->indexation_head($texte_head,$IDDoc);//fait l'indexation
    $texte = strip_tags($texte);//enleve les balises html
  }
  $separateurs =  "’'. ;\":,-…][(«»)/\r\n|\n|\r/" ;//caracteres de séparation des mots

  $tab_toks = $this->explode_bis(mb_strtolower($texte,"UTF-8"), $separateurs);//séparation

  $command = escapeshellcmd("python script/lemma.py ".implode(" ", $tab_toks));//fait la lemmatisation
  $output = shell_exec($command);
  $tabLemma = explode("|", $output);
  array_pop($tabLemma);
  $tabLemma = array_map("utf8_encode", $tabLemma );

  $tab_new_mots_occurrences = array_count_values ($tabLemma);//compte le nombre d'occurence

  if($type == "Site"){
    $sums = array();
    foreach (array_keys($tab_new_mots_occurrences + $text_head) as $key) {
      $sums[$key] = @($tab_new_mots_occurrences[$key] + $text_head[$key]);
    }
    $tab_new_mots_occurrences = $sums;
  }

  foreach($tab_new_mots_occurrences as $k=> $v){//Boucle qui tourne dans le tableau $tab_new_mots_occurrences qui contient le mot avec son occurence et le document dont il provient
      $stringParts = str_split($k);
      sort($stringParts);
      $wordsort = implode($stringParts);
      $infos = array("word"=>$k,"wordsort"=>$wordsort,"occurence"=>$v,"fileID"=>$IDDoc);
      $m->addMot($infos);//ajoute dans la BDD
  }

}

public function indexation_head($text,$IDDoc){
  //$m = Model::getModel();

  $separateurs =  "’'. ,:-…][(«»)/\r\n|\n|\r/" ;//caracteres de séparation des mots

  $tab_toks = $this->explode_bis(mb_strtolower($text,"UTF-8"), $separateurs);//séparation

  $command = escapeshellcmd("python script/lemma.py ".implode(" ", $tab_toks));//fait la lemmatisation
  $output = shell_exec($command);
  $tabLemma = explode("|", $output);
  array_pop($tabLemma);
  $tabLemma = array_map("utf8_encode", $tabLemma );

  $tab_new_mots_occurrences = array_count_values ($tabLemma);//compte le nombre d'occurence
  foreach($tab_new_mots_occurrences as $key => $value){
    $tab_new_mots_occurrences[$key] = intval($tab_new_mots_occurrences[$key]) * 1.5;
  }
  return $tab_new_mots_occurrences;
}

public function action_lectureFolder(){
  $path= "docs";
  $this->explorerDir($path);//Appel la fonction
  echo "<script>alert(\"Le dossier a bien été scanné\")</script>";
  echo("<script>window.location = 'index.php';</script>");
}

function explorerDir($path){
  $extensionValide = array("txt");//extensions autorisées
  $folder = opendir($path);
  while($entree = readdir($folder))//Tant qu'on peut lire dans le dossier courant
  {		
    if($entree != "." && $entree != "..")//Si ce que la fonction readdir trouve n'est pas ".." et "."
    {
      
      if(is_dir($path."/".$entree))//Si c'est un dossier
      {
        $sav_path = $path;//Met le chemin courant dans une variable
        $path .= "/".$entree;//Met le chemin du dossier qu'il a trouvé dans une variable 		
        $this->explorerDir($path);//Fait un appel récursive (appel à lui meme) avec le nouveau chemin. (Explore le dossier trouvé)
        $path = $sav_path;//Met l'ancien chemin courant afin de continué à le parcourir
      }
      else
      {
        $path_source = $path."/".$entree;//	Variable contenant le chemin vers le fichier trouvé			
        
        $tmp = explode(".", $path_source);
        $type = end($tmp);//recupere l'extension du fichier courant
        $size = filesize($path_source);//recupere la taille du fichier courant

        $idrandom = str_replace(".","",uniqid('', true));

        if (in_array($type,$extensionValide)){//si c'est un fichier texte

          if (copy($path_source, 'src/Upload/'.$idrandom."_".stripAccents(str_replace(' ', '', $entree)))) {
                      $m = Model::getModel();
                      $filename = $idrandom."_".stripAccents(str_replace(' ', '', $entree));
                      $tmp_infos = ['name'=>$entree, 'description' =>substr(stripAccents(file_get_contents_utf8($path_source)), 0, 50), 'filename'=>$filename,'type'=>$type, 'size'=>$size];
          
                      $IdDocu = $m->addDoc($tmp_infos);//ajoute le fichier à la BDD
                      $this->indexation("src/Upload/".$filename,$IdDocu,"Document",$type);//fait l'indexation
          }     
        }
      }
    }
  }
  closedir($folder);
}

  
}

?>
