<?php
declare(strict_types=1);

namespace App\Controller;

use App\Core\Auth;
use App\Core\Database;
use App\Model\Wishlist;



class WishlistController extends BaseController
{
    public function index(): void
    {
        $this->requirePermission('wishlist.manage');

        $userId   = Auth::id();
        $wishlist = Database::getInstance()->query('
            SELECT o.id_offer,
                   o.title        AS titre,
                   e.name         AS entreprise,
                   o.remuneration AS salaire,
                   a.city         AS ville
            FROM wishlist w
            JOIN "Offer"      o ON o.id_offer      = w.id_offer
            JOIN "Entreprise" e ON e.id_entreprise = o.id_entreprise
            JOIN "Adress"     a ON a.id_adress     = e.id_adress
            WHERE w.id_user = ?
        ', [$userId])->fetchAll();

        $this->render('dashboard/wishlist.html.twig', [
            'title'    => 'Ma wish-list — StageHub',
            'user'     => Auth::user(),
            'wishlist' => $wishlist,
        ]);
    }

    public function add(): void
    {
        $this->requirePermission('wishlist.manage');

        $offreId = (int) ($_POST['offre_id'] ?? 0);
        $success = (new Wishlist())->add(Auth::id(), $offreId);

        $this->jsonResponse(['success' => $success]);
    }

    public function remove(): void
    {
        $this->requirePermission('wishlist.manage');

        $offreId = (int) ($_POST['offre_id'] ?? 0);
        $success = (new Wishlist())->remove(Auth::id(), $offreId);

        $this->jsonResponse(['success' => $success]);
    }

    private function jsonResponse(array $data): never
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}