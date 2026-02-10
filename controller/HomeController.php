<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../model/User.php';
require_once '../model/Cache.php';

class HomeController {
    public function index() {
        Cache::createTableIfNotExists();

        // Connexion à la base de données
        require_once '../model/Database.php';
        $pdo = Database::getConnection();

        $coursAlaUne = Cache::get('moocs_recent');
        if (!$coursAlaUne) {
            $stmt = $pdo->query('SELECT id, titre, description, image FROM moocs ORDER BY id DESC LIMIT 6');
            $coursAlaUne = $stmt->fetchAll(PDO::FETCH_ASSOC);
            Cache::set('moocs_recent', $coursAlaUne, 3600); 
        }

        // Livres recent 
        $livres = Cache::get('livres_recent');
        if (!$livres) {
            $stmtLivres = $pdo->query('SELECT id, titre, description, image FROM livres ORDER BY id DESC LIMIT 3');
            $livres = $stmtLivres->fetchAll(PDO::FETCH_ASSOC);
            Cache::set('livres_recent', $livres, 3600); 
        }

        // Actualités recentes 
        $actus = Cache::get('actualites_recent');
        if (!$actus) {
            $stmtActu = $pdo->query('SELECT titre, date_evt, texte FROM actualites ORDER BY date_evt DESC LIMIT 3');
            $actus = $stmtActu->fetchAll(PDO::FETCH_ASSOC);
            Cache::set('actualites_recent', $actus, 3600);
        }

        $news = Cache::get('newsapi_education');

        if (!$news) {
            $newsApiKey = '66e1912347f046faaa18a34308734930'; 
            $newsUrl = "https://newsapi.org/v2/everything?q=education&language=fr&pageSize=3&sortBy=publishedAt&apiKey=$newsApiKey";

            $ch = curl_init($newsUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; PHP curl)'); 
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($response && $httpCode === 200) {
                $data = json_decode($response, true);
                if (isset($data['status']) && $data['status'] === 'ok' && !empty($data['articles'])) {
                    $validArticles = array_filter($data['articles'], function ($article) {
                        return !empty($article['urlToImage']) && !empty($article['title']) && !empty($article['description']);
                    });

                    $news = array_slice(array_values($validArticles), 0, 3);
                    Cache::set('newsapi_education', $news, 3600); 
                    error_log("NewsAPI Success: " . count($news) . " articles valides récupérés et mis en cache");
                } else {
                    error_log("NewsAPI Error: " . ($data['message'] ?? 'Unknown error') . " | HTTP: $httpCode");
                    $news = [];
                }
            } else {
                error_log("NewsAPI cURL Error: HTTP $httpCode | Response: " . substr($response, 0, 200));
                $news = [];
            }
        } else {
            error_log("NewsAPI loaded from cache");
        }

        
        $radioShows = Cache::get('radiofrance_grid');

        if (!$radioShows) {
            $radioApiKey = '4a55b1c6-009b-4c46-b233-41bbd680abdc'; 
            $radioUrl = "https://openapi.radiofrance.fr/v1/graphql";

            $start = time() - 86400; 
            $end = time(); 

            $query = <<<GQL
{
  grid(
    start: $start
    end: $end
    station: FRANCECULTURE
    includeTracks: false
  ) {
    ... on DiffusionStep {
      id
      diffusion {
        id
        title
        standFirst
        url
        published_date
        podcastEpisode {
          id
          title
          url
          playerUrl
          created
          duration
        }
      }
    }
    ... on TrackStep {
      id
      track {
        id
        title
        albumTitle
      }
    }
    ... on BlankStep {
      id
      title
    }
  }
}
GQL;

            $ch = curl_init($radioUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                "X-Token: $radioApiKey"
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['query' => $query]));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; PHP curl)'); 
            $response = curl_exec($ch);

            if ($response === false) {
                $curlError = curl_error($ch);
                curl_close($ch);
                error_log("Radio France cURL Error: $curlError");
                $radioShows = [];
            } else {
                curl_close($ch);
                $data = json_decode($response, true);
                $radioShows = [];

                if (!empty($data['data']['grid'])) {
                    $diffusions = array_filter($data['data']['grid'], function($step) {
                        return isset($step['diffusion']); 
                    });
                    $radioShows = array_slice(array_values($diffusions), 0, 3); 
                    Cache::set('radiofrance_grid', $radioShows, 3600); 
                    error_log("Radio France Success: " . count($radioShows) . " diffusions récupérées et mises en cache");
                } else {
                    error_log("Radio France API Error: " . json_encode($data['errors'] ?? 'No data or unknown error'));
                }
            }
        } else {
            error_log("Radio France loaded from cache");
        }

        $data = [
            'coursAlaUne' => $coursAlaUne,
            'livres' => $livres,
            'actus' => $actus,
            'news' => $news,
            'radioShows' => $radioShows
        ];

        extract($data);
        require_once '../view/home_view.php';
    }
}
?>
