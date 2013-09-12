<?php


class Application
{
    public $Plateforme;
    public $id;
    public $nom;
    public $sections;

    function __construct($id, $nom, Plateforme $Plateforme, $sections = null)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->Plateforme = $Plateforme;
        $this->sections = $sections === null ? array() : $sections;
    }

    /**
     * @param $id
     * @return Section|null
     */
    public function findSectionById($id)
    {
        foreach ($this->sections as $section) {
            if ($section->id == $id) {
                return $section;
            }
        }
        return null;
    }

    public function getSections()
    {
        $sections = array();
        $dossier = DIR . '/datas/' . $this->Plateforme->id . '/' . $this->id;
        $fichiers = scandir($dossier, 1);
        foreach ($fichiers as $fichier) {
            if ($fichier == '.' || $fichier == '..') {
                continue;
            }
            if (is_dir($dossier . '/' . $fichier)) {
                $sections[] = new Section($fichier, $this);
            }
        }
        return $sections;
    }
}