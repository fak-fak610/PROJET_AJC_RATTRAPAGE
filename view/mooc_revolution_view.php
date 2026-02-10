<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque numérique</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/projet_ajc_php100/css/bibli.css?v=2.4">
  </head>

<?php include '../includes/header.php'; ?>


<body></body>

<section class="art-hero d-flex align-items-center" 
         style="background-image: url('https://www.geekjunior.fr/wp-content/uploads/2023/04/mooc-800x600.jpeg'); background-size: cover; background-position: center; background-attachment: fixed; height: 80vh; position: relative;">

  <!-- superposition sombre -->
  <div class="art-hero__overlay" 
       style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4);" 
       aria-hidden="true"></div>

  <div class="container text-center art-hero__content position-relative text-white">
    <h1 class="fw-bold display-6">Les MOOCs, une révolution pédagogique</h1>
    <p class="lead">Le MOOC repose sur un format 100 % numérique qui combine vidéos pédagogiques, quiz interactifs, forums de discussion et exercices pratiques.</p>
    
    <a href="index.php?page=mooc_revolution"
       target="_blank"
       class="btn btn-light mt-3">
       Découvrir le MOOC
    </a>
  </div>
</section>


<!-- Bloc texte style Europeana -->
<section class="story-text py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h3 class="fw-bold mb-4">Qu'est-ce que ça veut dire ?</h3>
        <p>
         Le MOOC (Massive Open Online Course) , sont des formations interactives dispensées en ligne et ouvertes à tous, par inscription.
Ils représentent une rupture dans les modes traditionnels d’enseignement.
en démocratisant l’accès au savoir et en s’appuyant sur des outils numériques interactifs (vidéos, forums, quiz, travaux collaboratifs).
Le MOOC contient des périodes d'apprentissages qui varient en fonction des périodes, pouvant être courtes ou longues selon le contenu du cours, le rythme de l’apprenant et les objectifs pédagogiques. Certaines sont organisées de manière hebdomadaire avec des vidéos et des quiz, tandis que d’autres s’étendent sur plusieurs semaines avec des projets.
        </p>
                <h3 class="fw-bold mb-4">Qu'est-ce qu'on apprend dans un MOOC ?</h3>
        Mathématiques, physique, chimie,biologie ,informatique,programmation ,création de jeux en ligne, d'applis,ingénierie et robotique,montage de projet, création de start-up, médecine, codage.....
        De nombreux MOOC en français sont disponibles. Si vous parlez bien l'anglais, le choix des matières et des niveaux est bien sûr beaucoup plus large
        <p>
               <h3 class="fw-bold mb-4">Quels sont les principaux avantages pédagogiques d’un MOOC ?</h3>
                 
        </p>
        
Les MOOCs offrent une grande flexibilité d’apprentissage, 
favorisent l’autonomie et permettent d’échanger avec une communauté internationale d’apprenants.
        <p>
        </p>
                       <h3 class="fw-bold mb-4">En quoi les MOOCs représentent-ils une révolution pédagogique ?</h3>

        <p>
          Ils transforment le rôle de l’enseignant, qui devient davantage un guide qu’un transmetteur de savoir, 
          et placent l’apprenant au centre du processus d’apprentissage.
        </p>
        <p>
          Le Caravage peint deux versions de la Cène à Emmaüs : la première en 1601,
          conservée à la National Gallery de Londres, et la seconde en 1606,
          aujourd'hui à la Pinacothèque de Brera à Milan. Les deux œuvres représentent
          le moment où les disciples reconnaissent Jésus en train de rompre le pain.
        </p>
                               <h3 class="fw-bold mb-4">Les MOOCs peuvent-ils remplacer l’enseignement traditionnel ?</h3>
                               <p>
                                Non, ils le complètent plutôt. Ils apportent souplesse et ouverture, mais ne remplacent pas l’encadrement, 
                                l’accompagnement et la pratique en présentiel.
                               </p>

      </div>
    </div>
  </div>
</section>

<section class="story-gallery py-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow-sm h-100">
          <img src="https://missionslocales-bfc.fr/mission-locale-bassin-graylois/wp-content/uploads/sites/6/2020/06/MOOC..png"
               class="card-img-top" alt="Illustration des MOOCs montrant l'accès ouvert à l'éducation en ligne">
          <div class="card-body">
            <p class="card-text small">
              Les MOOCs permettent un apprentissage flexible et accessible à tous, favorisant l'inclusion éducative.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm h-100">
          <img src="https://f.maformation.fr/edito/sites/3/2022/02/cooc-mooc.jpeg"
               class="card-img-top" alt="Image représentant la collaboration et l'échange dans les cours en ligne">
          <div class="card-body">
            <p class="card-text small">
              Les forums de discussion et les travaux collaboratifs enrichissent l'expérience d'apprentissage.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm h-100">
          <img src="https://digitiz.fr/wp-content/uploads/2018/09/MOOC.png"
               class="card-img-top" alt="Graphique illustrant la révolution pédagogique apportée par les MOOCs">
          <div class="card-body">
            <p class="card-text small">
              Les MOOCs transforment l'enseignement traditionnel en plaçant l'apprenant au centre du processus.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<?php include '../includes/footer.php'; ?>
