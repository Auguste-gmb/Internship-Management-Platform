<?php
declare(strict_types=1);

namespace App\Model;

class Entreprise
{
    public static function fakeList(): array
    {
        return [
            ['id' => 1,  'nom' => 'Accenture',          'secteur' => 'Conseil & Numérique',       'note' => 5, 'offres' => 12, 'tags' => ['Dev', 'Data', 'Cloud']],
            ['id' => 2,  'nom' => 'Capgemini',           'secteur' => 'ESN / Conseil IT',          'note' => 4, 'offres' => 9,  'tags' => ['PHP', 'Java']],
            ['id' => 3,  'nom' => 'Sopra Steria',        'secteur' => 'ESN / Transformation',      'note' => 5, 'offres' => 7,  'tags' => ['DevOps', 'Agile']],
            ['id' => 4,  'nom' => 'Alten',               'secteur' => 'Ingénierie & R&D',          'note' => 4, 'offres' => 5,  'tags' => ['Embarqué', 'C++']],
            ['id' => 5,  'nom' => 'Orange Group',        'secteur' => 'Télécommunications',        'note' => 4, 'offres' => 8,  'tags' => ['Réseau', '5G']],
            ['id' => 6,  'nom' => 'BNP Paribas',         'secteur' => 'Banque & Finance',          'note' => 5, 'offres' => 6,  'tags' => ['Finance', 'Excel']],
            ['id' => 7,  'nom' => 'Thales',              'secteur' => 'Défense & Aérospatial',     'note' => 5, 'offres' => 11, 'tags' => ['Embarqué', 'IA']],
            ['id' => 8,  'nom' => 'Dassault Systèmes',   'secteur' => 'Logiciels industriels',     'note' => 4, 'offres' => 4,  'tags' => ['3D', 'CAO']],
            ['id' => 9,  'nom' => 'Airbus',              'secteur' => 'Aéronautique',              'note' => 5, 'offres' => 10, 'tags' => ['Python', 'Matlab']],
            ['id' => 10, 'nom' => 'Société Générale',    'secteur' => 'Banque & Assurance',        'note' => 4, 'offres' => 5,  'tags' => ['Finance', 'Risk']],
            ['id' => 11, 'nom' => 'Michelin',            'secteur' => 'Industrie manufacturière',  'note' => 5, 'offres' => 7,  'tags' => ['Supply Chain', 'IoT']],
            ['id' => 12, 'nom' => 'Schneider Electric',  'secteur' => 'Énergie & Automatisation',  'note' => 4, 'offres' => 6,  'tags' => ['IoT', 'Green IT']],
        ];
    }

    public static function fakeById(int $id): ?array
    {
        $all = array_column(self::fakeList(), null, 'id');
        return $all[$id] ?? null;
    }
}