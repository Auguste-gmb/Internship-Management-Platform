<?php
declare(strict_types=1);

namespace App\Model;

use App\Core\Model;


class Wishlist extends Model
{
    public function add(int $userId, int $offerId): bool
    {
        try {
            $this->query(
                'INSERT INTO "wishlist" (id_user, id_offer) VALUES (?, ?) ON CONFLICT DO NOTHING',
                [$userId, $offerId]
            );
            return true;
        } catch (\Exception) {
            return false;
        }
    }

    public function remove(int $userId, int $offerId): bool
    {
        try {
            $this->query(
                'DELETE FROM "wishlist" WHERE id_user = ? AND id_offer = ?',
                [$userId, $offerId]
            );
            return true;
        } catch (\Exception) {
            return false;
        }
    }

    public function isInWishlist(int $userId, int $offerId): bool
    {
        $result = $this->fetchColumn(
            'SELECT 1 FROM "wishlist" WHERE id_user = ? AND id_offer = ?',
            [$userId, $offerId]
        );
        return (bool) $result;
    }

    public function getUserWishlist(int $userId): array
    {
        return $this->fetchAll(
            'SELECT id_offer FROM "wishlist" WHERE id_user = ?',
            [$userId]
        );
    }
}