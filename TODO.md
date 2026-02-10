# Corrections pour le Bloc 2 Front-End

## Étape 1: Corriger les balises de fermeture manquantes ✅

- Ajouter `</body>` et `</html>` dans `includes/footer.php`

## Étape 2: Déplacer les liens CSS du footer vers le header ✅

- Déplacer `<link rel="stylesheet" href="../assets/css/footer.css">` de `includes/footer.php` vers `includes/header.php`

## Étape 3: Supprimer le JS inline ✅

- Supprimer le script inline dans `view/formation_view.php` et le remplacer par un fichier JS externe
- Vérifier et corriger d'autres fichiers avec JS inline (admin, etc.)

## Étape 4: Vérifier la hiérarchie des titres ✅

- S'assurer que les titres suivent une hiérarchie logique (pas de h5 après h2 sans h3/h4)

## Étape 5: Améliorer l'accessibilité ✅

- Vérifier les attributs alt pour les images
- Ajouter des labels et aria-labels si nécessaire

## Étape 6: Optimiser l'intégration des assets ✅

- Vérifier que les assets sont bien chargés

## Étape 7: Utiliser des variables CSS (déjà fait) ✅

- Confirmer l'utilisation de variables dans `assets/css/style.css`

## Étape 8: Réduire les unités absolues ✅

- Préférer rem/em à px dans le CSS

## Étape 9: Assurer Desktop First ✅

- Vérifier les media queries

## Étape 10: Tester et finaliser ✅
