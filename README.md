# Bibliothéque

Cette aplication permet de gérer les emprunts , les emprunteurs et les livres.

## Installation

    fixture -> composer require orm-fixtures --dev
    faker -> composer require fakerphp/faker

## Cahier des charges

### User
    Cette classe représente de l'administrateur.

    - id : clé primaire
    - email : varchar 190
    - roles : text
    - password : varchar 190

    Relations:
    - aucune

    Données Indispensables : 
    - admin@example.com / 123 / Admin
    - foo.foo@example.com / 123 / Emprunteur
    - bar.bar@example.com / 123 / Emprunteur
    - baz.baz@example.com / 123 / Emprunteur

    Données de test : 
    - 100 users en donnée aléatoire

    Attention : chaque user doit être relié à un emprunteur mais n'oubliez pas que la relation est unidirectionnelle et qu'elle n'est visible que depuis l'emprunteur

### Livre
    Cette classe représente les livres contenus dans la bibliothéque.

    - id : clé primaire
    - titre : varchar 190
    - anneeEdition : int, nullable
    - nbrPages : int
    - codeIsbn : varchar 190, nullable

    Relations :
    - auteur : many to one
    - genres : many to many
    - emprunts : one to many

    Données indispensables :
    - Lorem ipsum dolor sit ame / 2010 / 100 / 9785786930024 / 1
    - Consectetur adipiscing elit / 2011 / 150 / 9783817260935 / 2 
    - Mihi quidem Antiochum / 2012 / 200 / 9782020493727 / 3
    - Quem audis satis belle / 2013 / 250 / 9794059561353 / 4 

    Données de test 
    - 1000 livres en donnée aléatoire

### Auteur
    Cette classe représente les auteurs des livres.

    - id : clé primaire
    - nom : varchar 190
    - prénom : varchar 190

    Relations :

    - livres : one to many

    Données indispensables :
    - auteur inconnu
    - Cartier / Huges
    - Lambert / Armand
    - Moitessier / Thomas

    Données de test : 500 auteurs en donnée aléatoire

### Genre
    Cette classe repésente les genres des livres

    - id : clé primaire
    - nom : varchar 190
    - description : text, nullable

    Relations:
    - livres : Many To Many

    Données indispensables: 
    - Poésie
    - Nouvelle
    - Roman historique
    - Roman d'amour
    - Roman d'aventure
    - Science-fiction
    - Fantasy
    - Biographie
    - Conte
    - Témoignage
    - Théatre
    - Essai
    - Journal intime

### Emprunteur
    Cette classe représente les emprunteurs de livre.

    - id : clé primaire
    - nom : varchar 190
    - prénom : varchar 190
    - tel : varchar 190 
    - actif : boolean
    - dateCreation : datetime
    - dateModification : datetime, nullable

    Relations:  
    - emprunts : One To Many
    - user : One To One, Unidirectionnel

    Données indipensables : 
    - foo / foo / foo.foo@example.com / 123456789 / true / 20200101 10:00:00 / NULL  
    - bar / bar / bar.bar@example.com / 123456789 / false / 20200201 11:00:00 / 0200501 12:00:00 
    - baz / baz / baz.baz@example.com / 123456789 / true / 20200301 12:00:00 / NULL

    Données de test : 100 emprunteur en donnée aléatoire

    Attention : chaque emprunteur doit être relié à un compte user.

### Emprunt
    Cette classe représente les emprunts de livre.

    - id : clé primaire
    - dateEmprunt : datetime
    - dateRetour : datetime, nullable

    Relations: 
    - emprunteur : Many To One
    - livre : Many To One

    Données indispensables : 
    - 2020-02-01 10:00:00 / 2020-03-01 10:00:00 / 1 / 1 
    - 2020-03-01 10:00:00 / 2020-04-01 10:00:00 / 2 / 2 
    - 2020-04-01 10:00:00 / NULL / 3 / 3 

    Données de test : 200 emprutns en donnée aleatoire.
    