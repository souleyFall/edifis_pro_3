# edifis_pro_3

# 🏗️ Édifis Pro – Application de Planification des Chantiers

## 📌 Présentation

Édifis Pro est une application web destinée à améliorer la gestion de la planification des salariés sur les chantiers dans le secteur du BTP. Elle permet :

- La création, modification et suppression de chantiers.
- L’affectation des salariés à différents chantiers.
- La visualisation simplifiée du planning.
- La gestion des utilisateurs (admin et salariés).

Ce projet a été développé dans le cadre d’un **hackathon** par une équipe de 4 développeurs fullstack.

---

## 🛠️ Stack Technique

- **Backend** : [Symfony 6+](https://symfony.com/)
- **Frontend** : [Twig](https://twig.symfony.com/) + HTML/CSS + Bootstrap
- **Base de données** : MySQL
- **ORM** : Doctrine
- **Tests** : PHPUnit
- **Outils** :
  - Diagrammes : UML
  - Maquettes : Figma
  - Git/GitHub

---

## 👨‍💻 L'Équipe

- **Abdelbar Sadji** 
- **Alex Millon** 
- **Souleymane FALL
- **Stive Gamy**

---

## 🚀 Déploiement Local

Voici les étapes pour installer et lancer le projet en local sur ta machine.

### 1. 📦 Cloner le projet

```bash
git clone https://github.com/<votre-repo>/edifis-pro.git
cd edifis-pro

2. ⚙️ Installer les dépendances PHP (via Composer)

Assure-toi d’avoir PHP 8.1+ et Composer installés.

composer install

3. 🧪 Copier le fichier .env

cp .env .env.local

Dans le fichier .env.local, configure ta connexion à la base de données MySQL :

DATABASE_URL="mysql://username:password@127.0.0.1:3306/edifis"

4. 🧱 Créer la base de données + les tables

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

Lancer le serveur local :

php -S localhost:8000 -t public

7. 🔐 Accès par défaut

    Admin : admin@mail / admin

    Employé : jean@mail / test

    Modifiables en base de données.

🧪 Lancer les tests

php bin/phpunit

🗺️ Diagrammes et Maquettes

    Maquettes Figma : lien à insérer ici
