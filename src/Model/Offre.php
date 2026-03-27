<?php
declare(strict_types=1);

namespace App\Model;

class Offre
{
    public static function fakeList(): array
    {
        return [
            [
                'id'         => 1,
                'titre'      => 'Banquier Analyste Junior',
                'entreprise' => 'BNP Paribas',
                'domaine'    => 'Finance',
                'ville'      => 'Rouen',
                'salaire'    => '950 €/mois',
                'date'       => 'Il y a 2 jours',
                'tags'       => ['Finance', 'Excel', 'Analyse'],
            ],
            [
                'id'         => 2,
                'titre'      => 'Développeur Full-Stack PHP/JS',
                'entreprise' => 'Accenture',
                'domaine'    => 'Informatique',
                'ville'      => 'Paris',
                'salaire'    => '800 €/mois',
                'date'       => 'Il y a 1 jour',
                'tags'       => ['PHP', 'JavaScript', 'MySQL'],
            ],
            [
                'id'         => 3,
                'titre'      => 'Stage UX/UI Designer',
                'entreprise' => 'Capgemini',
                'domaine'    => 'Design',
                'ville'      => 'Lyon',
                'salaire'    => '700 €/mois',
                'date'       => 'Il y a 3 jours',
                'tags'       => ['Figma', 'CSS', 'Responsive'],
            ],
            [
                'id'         => 4,
                'titre'      => 'Analyste Données & Reporting',
                'entreprise' => 'Sopra Steria',
                'domaine'    => 'Data / IA',
                'ville'      => 'Bordeaux',
                'salaire'    => '850 €/mois',
                'date'       => 'Il y a 5 jours',
                'tags'       => ['SQL', 'Python', 'Power BI'],
            ],
            [
                'id'         => 5,
                'titre'      => 'Ingénieur DevOps',
                'entreprise' => 'Alten',
                'domaine'    => 'DevOps',
                'ville'      => 'Toulouse',
                'salaire'    => '900 €/mois',
                'date'       => 'Il y a 1 jour',
                'tags'       => ['Docker', 'Linux', 'CI/CD'],
            ],
            [
                'id'         => 6,
                'titre'      => 'Chef de projet digital',
                'entreprise' => 'Orange Group',
                'domaine'    => 'Management',
                'ville'      => 'Paris',
                'salaire'    => '780 €/mois',
                'date'       => 'Il y a 7 jours',
                'tags'       => ['Agile', 'Scrum', 'Jira'],
            ],
        ];
    }

    public static function fakeById(int $id): ?array
    {
        $all = array_column(self::fakeList(), null, 'id');
        return $all[$id] ?? null;
    }
}