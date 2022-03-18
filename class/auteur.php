<?php
/**
 * Créer la classe Auteur
 */
class Auteur extends Database {
    /** @param id  */
    private $id;
    /** @param nom  */
    private $nom;
    /** @param prenom  */
    private $prenom;
    /** @param genre  */
    private $genre;
    /** @param nationalite  */
    private $nationalite;
    public function __construct(int $id=0,string $nom ="",string $prenom="",string $genre="", string $nationalite="")
    {
        parent::__construct();
        if($id === 0) {
        $auteur = parent::query('INSERT INTO auteur (Nom,Prenom,Genre,Nationalite) VALUES (?,?,?,?)', [$nom, $prenom, $genre, $nationalite]);
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->genre = $genre;
        $this->nationalite = $nationalite;
         }
        else{
            $auteur = parent::find("auteur", strval($id));

            $this->id = $id;
            $this->nom = count($auteur) == 1 ? $auteur[0]["Nom"]: null;
            $this->prenom = count($auteur) == 1 ? $auteur[0]["Prenom"]: null;
            $this->genre = count($auteur) == 1 ? $auteur[0]["Genre"]: null;
            $this->nationalite = count($auteur) == 1 ? $auteur[0]["Nationalite"]: null;
            }
    }

    public function setId(int $id){
        return $this->id = $id;
    }
    public function getId(): ?int{
        return $this->id;
    }
    public function setNom(string $nom){
        return $this->nom = $nom;
    }
    public function getNom(): ?string {
        return $this->nom;
    }
    public function setPrenom(string $prenom){
        return $this->prenom = $prenom;
    }
    public function getPrenom(): ?string{
        return $this->prenom;
    }
    public function setGenre(string $genre){
        return $this->genre = $genre;
    }
    public function getGenre(): ?string{
        return $this->genre;
    }
    public function setNationalite(string $nationalite){
    return $this->nationalite = $nationalite;
    }
    public function getNationalite(): ?string{
        return $this->nationalite;
    }
}