# tcc-projects

Projetos referentes a arquitetura para produção de séries temporais a partir de fontes de dados heterogêneas.

Configuração do banco de dados:

  No arquivo ".env" do registrador de adaptadores contém as informações necessárias para a conexão com o banco de dados.
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=middleware
  DB_USERNAME=root
  DB_PASSWORD=

deve-se criar um banco de dados com o nome "middleware" utilizando mysql, de preferência utilizar o usuário root com senha em branco, caso queira mudar,
apenas altere no arquivo essas opção tanto no registrador de adaptadores como no serviço produtor de séries.

-Requisitos para a execução da implementação: composer instalado, mysql, java 8, node versão 14 ou superior.


 - Integrador de fontes: necessida do node instalado versão 14 ou superior. Rodar os comandos "npm install" e "npm start" respectivamente.
 - Registrador de adaptadores: rodar "composer install" depois "php -S localhost:8082 -t public/"
 - Adaptador hidrológico: rodar "composer install" depois "php -S localhost:8088 -t public/", logo após, executar o comando "php artisan db:seed --class=GravarEventosHidrologicoSeeder" para realizar a coleta das observações.
 - Adaptador Twitter: configurar a sua chave de acesso com a plataforma Twitter e executar o programa.
 - Produtor de séries temporais: rodar "composer install" depois "php -S localhost:8083 -t public/"
 - Frontend: executar "npm install" e "npm start"
 

Executar os comandos SQL caso não queira criar a base do zero.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `middleware`
--

-- --------------------------------------------------------

--
-- Table structure for table `eventos`
--

CREATE TABLE `eventos` (
  `id` int(10) UNSIGNED NOT NULL,
  `regra_id` int(10) UNSIGNED NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cidade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dataHora` datetime NOT NULL,
  `valorNumero` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valorTexto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `regras` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigoRegra` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomeFonte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomeAdaptador` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `campoReferenciaTexto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `campoReferenciaNumero` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `campoReferenciaDataHora` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `campoLocalizacao1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `campoLocalizacao2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `campoLocalizacao3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `campoCodigo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atributos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`atributos`)),
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eventos_regra_id_foreign` (`regra_id`);
  
  ALTER TABLE `regras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regras_codigoregra_unique` (`codigoRegra`);

-- As regras já registradas:

INSERT INTO `regras` (`id`, `codigoRegra`, `nomeFonte`, `nomeAdaptador`, `campoReferenciaTexto`, `campoReferenciaNumero`, `campoReferenciaDataHora`, `campoLocalizacao1`, `campoLocalizacao2`, `campoLocalizacao3`, `campoCodigo`, `descricao`, `atributos`, `token`, `created_at`, `updated_at`) VALUES
(1, 'twitter', 'twitter', 'Sensor social - Twitter', 'textValue', NULL, 'timeStamp', 'latitude', 'longitude', NULL, 'id', 'Regra referente ao adaptador que coleta dados da rede social do twitter', '[{\"nome\":\"id\",\"tipo\":\"number\"},{\"nome\":\"codigo_regra\",\"tipo\":\"string\"},{\"nome\":\"timeStamp\",\"tipo\":\"dateTime\"},{\"nome\":\"textValue\",\"tipo\":\"string\"},{\"nome\":\"latitude\",\"tipo\":\"number\"},{\"nome\":\"longitude\",\"tipo\":\"number\"}]', 'b73c2d22763d1ce2143a3755c1d0ad3a', '2021-10-09 22:45:30', '2021-10-09 22:45:30'),
(2, 'cemaden-hidrologico', 'cemaden', 'cemaden-h', NULL, 'nivel', 'dataHora', 'latitude', 'longitude', 'cidade', 'id', 'Regra referente ao adaptador que coleta dados do cemaden', '[{\"nome\":\"codestacao\",\"tipo\":\"string\"},{\"nome\":\"tipo\",\"tipo\":\"dateTime\"},{\"nome\":\"nivel\",\"tipo\":\"number\"},{\"nome\":\"latitude\",\"tipo\":\"number\"},{\"nome\":\"longitude\",\"tipo\":\"number\"},{\"nome\":\"chuva\",\"tipo\":\"number\"},{\"nome\":\"dataHora\",\"tipo\":\"dateTime\"},{\"nome\":\"nome\",\"tipo\":\"string\"},{\"nome\":\"uf\",\"tipo\":\"string\"},{\"nome\":\"cidade\",\"tipo\":\"string\"}]', '0a23b2bf028ca72e4ae2808962bf6ec6', '2021-10-10 04:14:36', '2021-10-10 04:14:36'),
(4, 'cemaden-pluviometrica', 'cemaden', 'Sensor físico - Cemaden', NULL, 'chuva', 'dataHora', 'latitude', 'longitude', 'cidade', 'codestacao', 'Regra referente ao adaptador que coleta dados do cemaden', '[{\"nome\":\"codestacao\",\"tipo\":\"string\"},{\"nome\":\"tipo\",\"tipo\":\"dateTime\"},{\"nome\":\"latitude\",\"tipo\":\"number\"},{\"nome\":\"longitude\",\"tipo\":\"number\"},{\"nome\":\"chuva\",\"tipo\":\"number\"},{\"nome\":\"dataHora\",\"tipo\":\"dateTime\"},{\"nome\":\"nome\",\"tipo\":\"string\"},{\"nome\":\"uf\",\"tipo\":\"string\"},{\"nome\":\"cidade\",\"tipo\":\"string\"}]', 'c2c44284ee457a116ea7c8b067f99a3a', '2021-10-10 04:18:51', '2021-10-10 04:18:51');


