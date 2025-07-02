<?php
// Nom de l'application
define('APP_NAME', 'E-Barber');

// URL de base de l’application (à ajuster si besoin)
define('BASE_URL', 'http://localhost/e-barber/public');

define('ROOT_RELATIVE_PATH', '/e-barber/public');


// Chemin absolu vers le dossier public
define('PUBLIC_PATH', dirname(__DIR__, 2) . '/public');

// Dossier pour stocker les images uploadées
define('UPLOADS_PATH', PUBLIC_PATH . '/assets/uploads');
define('UPLOADS_URL', BASE_URL . '/assets/uploads');

// Fuseau horaire par défaut (Lubumbashi)
date_default_timezone_set('Africa/Lubumbashi');

// Messages système (tu peux les traduire ici globalement si besoin)
define('LOGIN_ERROR', 'Email ou mot de passe incorrect');
define('ACCESS_DENIED', 'Accès refusé');
