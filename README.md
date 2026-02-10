"# PROJET_AJC_RATTRAPAGE" 
# Projet AJC - Centre MOOC - BIBLIOTHEQUE

## Description

Le **Projet AJC - Centre MOOC-BIBLIOTHEQUE ** est une plateforme éducative développée en PHP utilisant l'architecture MVC (Modèle-Vue-Contrôleur). Ce site web permet aux utilisateurs d'accéder à des cours en ligne ouverts et massifs (MOOC), de consulter une bibliothèque numérique, et d'interagir avec du contenu éducatif. Il offre également des fonctionnalités d'administration pour gérer les utilisateurs, les cours et les ressources.

Le site est conçu pour être accessible via un serveur local comme WAMP, et nécessite une base de données pour stocker les informations des utilisateurs, des cours et des ressources.

## Fonctionnalités principales

- **Accès aux MOOC** : Les utilisateurs peuvent consulter et suivre des cours en ligne.
- **Bibliothèque numérique** : Accès à une collection de livres et de documents pédagogiques.
- **Gestion des utilisateurs** : Inscription, connexion, gestion du profil et récupération de mot de passe.
- **Favoris** : Les utilisateurs peuvent ajouter des cours à leurs favoris.
- **Administration** : Interface d'administration pour gérer les utilisateurs, les MOOC, les livres et les actualités.
- **Actualités éducatives** : Intégration d'actualités éducatives via une API externe (NewsAPI).
- **Émissions radio** : Affichage des dernières émissions de France Culture via une API externe.
- **Téléchargement de documents** : Possibilité de télécharger des documents et des ressources.

## Prérequis

- **Serveur local** : WAMP (Windows Apache MySQL PHP) ou équivalent (XAMPP, MAMP).
- **Base de données** : MySQL ou MariaDB.
- **PHP** : Version 7.4 ou supérieure.
- **Navigateur web** : Chrome, Firefox ou Edge pour accéder au site.

## Installation

1. **Téléchargez et installez WAMP** : Assurez-vous que WAMP est installé et configuré sur votre machine.
2. **Clonez ou téléchargez le projet** : Placez les fichiers du projet dans le répertoire `www` de WAMP (par exemple, `C:\wamp64\www\projet_ajc_php`).
3. **Configurez la base de données** :
   - Créez une base de données MySQL (par exemple, `projet_ajc`).
   - Importez les fichiers SQL fournis dans le dossier `uploads` (par exemple, `documents_user.sql` et `documents_biblio.sql`).
   - Modifiez le fichier `config.php` pour définir les paramètres de connexion à la base de données (hôte, nom de la base, utilisateur, mot de passe).
4. **Démarrez WAMP** : Lancez WAMP et assurez-vous que Apache et MySQL sont démarrés.
5. **Accédez au site** : Ouvrez votre navigateur et allez à `http://localhost/projet_ajc_php/public/`.

## Utilisation

- **Page d'accueil** : Affiche les cours à la une, les actualités locales, les actualités éducatives et les dernières émissions radio.
- **MOOC** : Parcourez les cours disponibles et consultez les détails de chaque cours.
- **Bibliothèque** : Accédez aux livres et documents pédagogiques.
- **Connexion/Inscription** : Créez un compte ou connectez-vous pour accéder à des fonctionnalités supplémentaires comme les favoris.
- **Administration** : Si vous êtes administrateur, accédez à `/admin_login` pour gérer le contenu du site.

## Structure du projet

- **controller/** : Contient les contrôleurs pour gérer la logique métier.
- **model/** : Contient les modèles pour interagir avec la base de données.
- **view/** : Contient les vues pour afficher les pages HTML.
- **public/** : Point d'entrée principal du site.
- **assets/** : Contient les fichiers CSS, images et autres ressources statiques.
- **includes/** : Contient les fichiers inclus comme les en-têtes et pieds de page.
- **upload/** : Dossier pour les fichiers téléchargés par les utilisateurs.

## API externes utilisées

- **NewsAPI** : Pour récupérer les actualités éducatives.
- **Radio France API** : Pour afficher les émissions de France Culture.

## Contributeurs

- Développé par Gaël Lutumba Et Fakri Leclerc

## Licence

Ce projet est sous licence MIT. Vous êtes libre de l'utiliser, le modifier et le distribuer selon les termes de la licence.

---

**Note** : Assurez-vous que la base de données est correctement configurée et que WAMP est en cours d'exécution pour que le site fonctionne correctement.
