<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\BaseController;

class LegalController extends BaseController
{
    public function mentions(): void
    {
        echo $this->twig->render('legal/mentions.html.twig', [
            'title' => 'StageHub — Mentions Légales',
            'meta_desc' => 'Trouvez votre stage idéal sur StageHub, la plateforme de stages CESI.'
        ]);
    }
}