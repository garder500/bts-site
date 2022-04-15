<?php
// include the database
include $_SERVER['DOCUMENT_ROOT'].'/src/repository/database.php';
include $_SERVER['DOCUMENT_ROOT'].'/src/repository/userRepository.php';
include $_SERVER['DOCUMENT_ROOT'].'/src/repository/mangaRepository.php';
include $_SERVER['DOCUMENT_ROOT'].'/src/repository/avisRepository.php';
include $_SERVER['DOCUMENT_ROOT'].'/src/repository/commandeRepository.php';
include $_SERVER['DOCUMENT_ROOT'].'/src/repository/artisteRepository.php';
include $_SERVER['DOCUMENT_ROOT'].'/src/repository/auteurRepository.php';
include $_SERVER['DOCUMENT_ROOT'].'/src/repository/detailCommandeRepository.php';

// make a new Class called EntityRepository
class EntityRepository extends Database
{
    use UserRepository;
    use mangaRepository;
    use avisRepository;
    use commandeRepository;
    use artisteRepository;
    use auteurRepository;
    use detailCommandeRepository;
    public function __construct()
    {
        parent::__construct();
    }

    public function select($class)
    {
        $type = get_class($class);
        if ($type === "User") {
            return $this->findUser($class);
        } elseif ($type === "Manga") {
            return $this->findManga($class);
        } elseif ($type === "Avis") {
            return $this->findAvis($class);
        } elseif ($type === "Commande") {
            return $this->findCommande($class);
        } elseif ($type === "Artiste") {
            return $this->findArtiste($class);
        } elseif ($type === "Auteur") {
            return $this->findAuteur($class);
        } elseif ($type === "DetailCommande") {
            return $this->findDetailCommande($class);
        }
    }

    public function insert($class)
    {
        $type = get_class($class);
        if ($type === "User") {
            return $this->insertUser($class);
        } elseif ($type === "Auteur") {
            return $this->insertAuteur($class);
        } elseif ($type === "Avis") {
            return $this->insertAvis($class);
        } elseif ($type === "Commande") {
            return $this->insertCommande($class);
        } elseif ($type === "DetailCommande") {
            return $this->insertDetailCommande($class);
        } elseif ($type === "Manga") {
            return $this->insertManga($class);
        } elseif ($type === "Artiste") {
            return $this->insertArtiste($class);
        }
    }

    public function delete($class)
    {
        $type = get_class($class);
        if ($type === "User") {
            return $this->deleteUser($class);
        } elseif ($type === "Auteur") {
            return $this->deleteAuteur($class);
        } elseif ($type === "Avis") {
            return $this->deleteAvis($class);
        } elseif ($type === "Commande") {
            return $this->deleteCommande($class);
        } elseif ($type === "DetailCommande") {
            return $this->deleteDetailCommande($class);
        } elseif ($type === "Manga") {
            return $this->deleteManga($class);
        } elseif ($type === "Artiste") {
            return $this->deleteArtiste($class);
        }
    }

    public function update($class)
    {
        $type = get_class($class);
        if ($type === "User") {
            return $this->updateUser($class);
        } elseif ($type === "Auteur") {
            return $this->updateAuteur($class);
        } elseif ($type === "Avis") {
            return $this->updateAvis($class);
        } elseif ($type === "Commande") {
            return $this->updateCommande($class);
        } elseif ($type === "DetailCommande") {
            return $this->updateDetailCommande($class);
        } elseif ($type === "Manga") {
            return $this->updateManga($class);
        } elseif ($type === "Artiste") {
            return $this->updateArtiste($class);
        }
    }


    public function searchManga(string $product){
        function makeArrayOfClassFromValues($value)
        {
            return (new EntityRepository)->select(new Manga($value["ID_MANGA"]));
        }

        $product = htmlspecialchars($product);
        $searchValues = parent::query("SELECT * FROM manga WHERE Titre LIKE '%$product%' OR Genre LIKE '%$product%' OR Editeur LIKE '%$product%'");
        if($searchValues->rowCount() > 0){
            $searchValues = $searchValues->fetchAll();
            return array_map("makeArrayOfClassFromValues",$searchValues);
        }else{
            return [];
        }
    }
}
