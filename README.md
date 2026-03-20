# Projet Web – *Internship Management Platform*

<!--
<p align="center">
  <img src="https://upload.wikimedia.org/wikipedia/commons/3/38/Internship_concept.jpg" alt="Plateforme de gestion de stages" style="max-width:100%;">
</p>
-->

## Sommaire

1. [Présentation du projet](#1-présentation-du-projet)
2. [Contexte et objectifs](#2-contexte-et-objectifs)
3. [Technologies et stack](#3-technologies-et-stack)
4. [Fonctionnalités principales](#4-fonctionnalités-principales)
5. [Organisation du code](#5-organisation-du-code)
6. [Structure du projet](#6-structure-du-projet)

--- 

**[Demo Frontend](https://auguste-gmb.github.io/Internship-Management-Platform/static/index.html)** 

## 1. Présentation du projet

**Internship Management Platform** est un projet de **développement web**.

Il consiste à concevoir une **application web centralisant les offres de stage** et permettant aux étudiants de :

* rechercher des stages correspondant à leurs compétences,
* postuler directement en ligne avec CV et lettre de motivation,
* gérer leur liste de souhaits (wish-list).

L’application offre également des interfaces spécifiques pour les **administrateurs**, les **pilotes de promotion** et les **étudiants**, garantissant un accès sécurisé et adapté selon le rôle.

---

## 2. Contexte et objectifs

Le projet est initié dans le cadre du **bloc Développement Web du PGE A2 CPI INFO**.

Objectifs principaux :

* Faciliter la **recherche et la gestion des stages** pour les étudiants et les pilotes de promotion.
* Offrir une **interface intuitive et responsive** adaptée à tous les écrans (desktop, tablette, mobile).
* Respecter les **bonnes pratiques de développement web** : MVC, sécurité, SEO, conformité légale.
* Mettre en place un **workflow de travail collaboratif** avec Git et la méthodologie Scrum.

---

## 3. Technologies et stack

### Backend

* **PHP** (POO obligatoire)
* **MVC / Composer / moteur de template**
* **MySQL** ou autre SGBD compatible SQL
* Gestion des accès et authentification sécurisée

### Frontend

* **HTML5 / CSS3 / JavaScript**
* **Responsive Design** (approche Mobile First)
* Menus dynamiques et interactivité côté client

### Serveur

* **Apache / HTTP**
* HTTPS obligatoire

### Outils complémentaires

* Tests unitaires avec **PHPUnit**
* Routage d’URL côté backend
* Fichiers **robots.txt** et **sitemap.xml** pour le SEO

---

## 4. Fonctionnalités principales

L’application permet :

* **Gestion des entreprises** : création, modification, suppression, recherche et évaluation.
* **Gestion des offres de stage** : création, modification, suppression, recherche, statistiques, wish-list.
* **Gestion des comptes utilisateurs** : étudiants, pilotes, administrateurs avec droits spécifiques.
* **Gestion des candidatures** : postuler, consulter ses candidatures ou celles de ses étudiants.
* **Fonctionnalités transversales** : pagination, mentions légales, sécurité, SEO, responsive design.

---

## 5. Organisation du code

Le code est structuré selon l’**architecture MVC** pour assurer :

* **Lisibilité et maintenabilité**
* Réutilisation des composants (header, footer, menus) via le moteur de template
* Séparation claire entre **logique métier**, **interface utilisateur** et **accès aux données**

---

## 6. Structure du projet

```
C:.
│
├─ .gitattributes          # Configuration Git
├─ README.md               # Documentation du projet
│
├─ public/                 # Contenu accessible publiquement (images, CSS, JS)
│
├─ src/
│   ├─ Controller/         # Contrôleurs MVC
│   ├─ Model/              # Modèles de données
│   ├─ View/               # Templates et vues
│   └─ Utils/              # Fonctions utilitaires et helpers
│
├─ config/                 # Configuration du projet (DB, routes, paramètres)
├─ tests/                  # Tests unitaires PHPUnit
└─ composer.json           # Gestionnaire de dépendances PHP
```

