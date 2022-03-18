<?php
include "./class/database.php";
include "./class/user.php";
include "./class/manga.php";
/**
 * Créer la classe Avis
 */
class Avis extends Database
{
    /** @param id reference ID_ */
    private $id;
    /** @param note reference Note */
    private $note;
    /** @param commentaire reference Commentaire */
    private $commentaire;
    /** @param date reference Date */
    private $date;
    /** @param manga reference ID_MANGA */
    private $manga;
    /** @param user reference ID_USER */
    private $user;

    public function __construct(int $id = 0, string $note = "", string $commentaire = "", DateTime $date, Manga $manga, User $user)
    {
        parent::__construct();
        if ($id === 0) {
            $avis = parent::query('INSERT INTO avis (Note,Commentaire,Date,ID_Manga,ID_USER) VALUES (?,?,?,?,?)', [$note, $commentaire, $date->format("YYYY-MM-DD hh:mm:ss"), $manga->getid(), $user->getid()]);
            $this->id = $id;
            $this->note = $note;
            $this->commentaire = $commentaire;
            $this->date = $date;
            $this->manga = $manga;
            $this->user = $user;
        } else {
            $avis = parent::find("avis", strval($id));

            $this->id = $id;
            $this->note = count($avis) == 1 ? $avis[0]["Note"] : null;
            $this->commentaire = count($avis) == 1 ? $avis[0]["Commentaire"] : null;
            $this->date = count($avis) == 1 ? new \DateTime($avis[0]["Date"]) : null;
            $this->id_manga = count($avis) == 1 ? new Manga(int($avis[0]["ID_MANGA"])) : null;
            $this->id_user = count($avis) == 1 ? new User(int($avis[0]["ID_USER"])) : null;
        }
    }

    public function setId(int $id)
    {
        return $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setNote(string $note){
        return $this->note = $note;
    }
    public function getNote(): ?string {
        return $this->note;
    }

    public function setCommentaire(string $commentaire){
        return $this->commentaire = $commentaire;
    }
    public function getCommentaire(): ?string {
        return $this->commentaire;
    }

    public function setDate(DateTime $date)
    {
        return $this->date = $date;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setManga(Manga $manga)
    {
        return $this->manga = $manga;
    }

    public function getManga(): ?Manga
    {
        return $this->manga;
    }

    public function setUser(User $user)
    {
        return $this->user = $user;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

}
