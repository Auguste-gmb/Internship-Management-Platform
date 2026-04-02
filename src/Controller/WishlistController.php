<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Database;

class WishlistController extends BaseController
{
    public function index(): void
    {
        $this->requireAuth();
        
        $userId = $_SESSION['user']['id'];
        $db = Database::getInstance();
        
        $wishlist = $db->query('
            SELECT o.id_offer, o.title AS titre, e.name AS entreprise,
                   o.remuneration AS salaire, a.city AS ville
            FROM whishlist w
            JOIN Offer o      ON o.id_offer      = w.id_offer
            JOIN Entreprise e ON e.id_entreprise = o.id_entreprise
            JOIN Adress a     ON a.id_adress     = e.id_adress
            WHERE w.id_user = ?
            ORDER BY w.id_whishlist DESC
        ', [$userId])->fetchAll();
        
        $this->render('dashboard/wishlist.html.twig', [
            'title'    => 'Ma wish-list — StageHub',
            'wishlist' => $wishlist,
        ]);
    }

    public function add(): void
    {
        $this->requireAuth();
        
        $userId  = $_SESSION['user']['id'];
        $offreId = (int)($_POST['offre_id'] ?? 0);
        
        Database::getInstance()->query(
            'INSERT IGNORE INTO whishlist (id_user, id_offer) VALUES (?, ?)',
            [$userId, $offreId]
        );
        
        echo json_encode(['success' => true]);
    }

    public function remove(): void
    {
        $this->requireAuth();
        
        $userId  = $_SESSION['user']['id'];
        $offreId = (int)($_POST['offre_id'] ?? 0);
        
        Database::getInstance()->query(
            'DELETE FROM whishlist WHERE id_user = ? AND id_offer = ?',
            [$userId, $offreId]
        );
        
        echo json_encode(['success' => true]);
    }
}