<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'cunha_frutas');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'cunha_frutas');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'YCj3cm1BbYIBU9N6');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'o@rG$QzXa7h+8T!;oB8/ &u)cy3}z2Lb<f&|ME~ Dm`le13fnHy>!s*cWE@##te4');
define('SECURE_AUTH_KEY',  ',.,<S*zJB7w[OXR.0q;JS%<}OR>@W5L&Pomn*ZXQar$I|7Z=#!Mw7>?:E6jLli={');
define('LOGGED_IN_KEY',    'M/L~9XEU@;GZXG;G0/S^TeI0?nMgSwtui9<[n&`bHdQS>iypF;ZZbk|1hp5Iv;mo');
define('NONCE_KEY',        'fVoBz=-@sW-}5eT(ts[h)HnE-3QWe#dq%2^9<0auY[C_a:O!Xt`X;ym4yf<y_@pO');
define('AUTH_SALT',        '2lH=$wo%B) c=I9SB[:+$Q;?a{xOg0ZH;vVnzmtvR1*bnps~$(oZdJ<Kmn<k[iZ*');
define('SECURE_AUTH_SALT', 'n^;mMH/;;L2Uc0_~A;TaMogqMHz^|XSQLPdzr]tQyl:HMvX`1xuW3?Vt-,~o@}E+');
define('LOGGED_IN_SALT',   'iTN&UFb%(s| tp~DCO%0]y[nLF&^V<jzveLK.`w%!LZliPwQIWc#PB[0 LU_%8E5');
define('NONCE_SALT',       'H8[Y84Mo3?|JfRG6(s<Il/d+,{`ZWy20:vzZy#:!Z;Doz;fZ$I>GY:4eTPj4ntvm');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
