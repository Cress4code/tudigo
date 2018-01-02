<?php
ob_start();
error_reporting(0);
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'tudigo_nakayo');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', '');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '$[0]c3X^D@}Va-YaP1EnfZj_M;,J8]}ie{%5@/kRW}}M|4bXXJd^tgj=DOly)tVE');
define('SECURE_AUTH_KEY',  'dQt!;%Npz:f?K@DSCIaA L7buIokoWkH-HZd:6y [OHR[rr~*eSgk2FIh1`F2x<F');
define('LOGGED_IN_KEY',    'z2hsrry Nc:7yWM<r ;9~e?dK,~`:<DQ!=fJ4b/DDIoGyPa#1s/RXWcG^7%P3Z+E');
define('NONCE_KEY',        'r7;]jQGGx4+yaQNS1!M!Tq,Sx*p)}Y LB|~ZDe(sbP^=x-lbnoZMhSn56wX+Z,G2');
define('AUTH_SALT',        ')~AKQH4w/_y:**5):nma8oNr_$6*ZHrHm2E=ti$Mr2+<=<&Vk*9LTQkr{G0JnDm@');
define('SECURE_AUTH_SALT', 'a4]CCfe{GO(|mbd:tE!/&MVp^.eIGE);BH>M]p2L0cmjI#G5BGcD&qL{n@NkpB`]');
define('LOGGED_IN_SALT',   'r+,VN$ZcI{DKqb)yr;wDXV#sh8AUKcJttr1T7s/rF{Nr1IeTJbt/SlL{rJde==r#');
define('NONCE_SALT',       'd>hGXwohlP*D-1i/:SWCQKQ^JyYMcB2s:HpY.k)#RbQ^El}mx~3n wt~E__Q>sUA');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'tg_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');