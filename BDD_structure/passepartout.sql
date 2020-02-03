
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Structure de la table `Classe`
--

CREATE TABLE IF NOT EXISTS `Classe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom_classe` varchar(25) DEFAULT NULL,
  `id_prof` int(10) unsigned NOT NULL,
  `moyenne` int(11) DEFAULT '0',
  `nb_enfant` smallint(5) unsigned DEFAULT NULL,
  `ed` varchar(10) NOT NULL DEFAULT 'ED1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=225 ;

-- --------------------------------------------------------

--
-- Structure de la table `Config`
--

CREATE TABLE IF NOT EXISTS `Config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code_prof` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `Config` (`id`, `code_prof`) VALUES
(1, 'your_code');

-- --------------------------------------------------------

--
-- Structure de la table `DefiClassement`
--

CREATE TABLE IF NOT EXISTS `DefiClassement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ed` varchar(10) NOT NULL,
  `langue_defi` varchar(5) NOT NULL,
  `region` varchar(70) DEFAULT NULL,
  `lieu` varchar(40) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `titre_question` varchar(70) DEFAULT NULL,
  `question` text,
  `nbValisette` smallint(6) DEFAULT NULL,
  `nom_valise_1` varchar(30) DEFAULT NULL,
  `nom_valise_2` varchar(30) DEFAULT NULL,
  `nom_valise_3` varchar(30) DEFAULT NULL,
  `nom_valise_4` varchar(30) DEFAULT NULL,
  `nom_valise_5` varchar(30) DEFAULT NULL,
  `type_etiquette` smallint(6) DEFAULT NULL,
  `valise_1_etiquette_1` varchar(100) DEFAULT NULL,
  `v1_e1_Owner` varchar(100) DEFAULT NULL,
  `v1_e1_CR` varchar(5) DEFAULT NULL,
  `valise_1_etiquette_2` varchar(100) DEFAULT NULL,
  `v1_e2_Owner` varchar(100) DEFAULT NULL,
  `v1_e2_CR` varchar(5) DEFAULT NULL,
  `valise_1_etiquette_3` varchar(100) DEFAULT NULL,
  `v1_e3_Owner` varchar(100) DEFAULT NULL,
  `v1_e3_CR` varchar(5) DEFAULT NULL,
  `valise_1_etiquette_4` varchar(100) DEFAULT NULL,
  `v1_e4_Owner` varchar(100) DEFAULT NULL,
  `v1_e4_CR` varchar(5) DEFAULT NULL,
  `valise_1_etiquette_5` varchar(100) DEFAULT NULL,
  `v1_e5_Owner` varchar(100) DEFAULT NULL,
  `v1_e5_CR` varchar(5) DEFAULT NULL,
  `valise_2_etiquette_1` varchar(100) DEFAULT NULL,
  `v2_e1_Owner` varchar(100) DEFAULT NULL,
  `v2_e1_CR` varchar(5) DEFAULT NULL,
  `valise_2_etiquette_2` varchar(100) DEFAULT NULL,
  `v2_e2_Owner` varchar(100) DEFAULT NULL,
  `v2_e2_CR` varchar(5) DEFAULT NULL,
  `valise_2_etiquette_3` varchar(100) DEFAULT NULL,
  `v2_e3_Owner` varchar(100) DEFAULT NULL,
  `v2_e3_CR` varchar(5) DEFAULT NULL,
  `valise_2_etiquette_4` varchar(100) DEFAULT NULL,
  `v2_e4_Owner` varchar(100) DEFAULT NULL,
  `v2_e4_CR` varchar(5) DEFAULT NULL,
  `valise_2_etiquette_5` varchar(100) DEFAULT NULL,
  `v2_e5_Owner` varchar(100) DEFAULT NULL,
  `v2_e5_CR` varchar(5) DEFAULT NULL,
  `valise_3_etiquette_1` varchar(100) DEFAULT NULL,
  `v3_e1_Owner` varchar(100) DEFAULT NULL,
  `v3_e1_CR` varchar(5) DEFAULT NULL,
  `valise_3_etiquette_2` varchar(100) DEFAULT NULL,
  `v3_e2_Owner` varchar(100) DEFAULT NULL,
  `v3_e2_CR` varchar(5) DEFAULT NULL,
  `valise_3_etiquette_3` varchar(100) DEFAULT NULL,
  `v3_e3_Owner` varchar(100) DEFAULT NULL,
  `v3_e3_CR` varchar(5) DEFAULT NULL,
  `valise_3_etiquette_4` varchar(100) DEFAULT NULL,
  `v3_e4_Owner` varchar(100) DEFAULT NULL,
  `v3_e4_CR` varchar(5) DEFAULT NULL,
  `valise_3_etiquette_5` varchar(100) DEFAULT NULL,
  `v3_e5_Owner` varchar(100) DEFAULT NULL,
  `v3_e5_CR` varchar(5) DEFAULT NULL,
  `valise_4_etiquette_1` varchar(100) DEFAULT NULL,
  `v4_e1_Owner` varchar(100) DEFAULT NULL,
  `v4_e1_CR` varchar(5) DEFAULT NULL,
  `valise_4_etiquette_2` varchar(100) DEFAULT NULL,
  `v4_e2_Owner` varchar(100) DEFAULT NULL,
  `v4_e2_CR` varchar(5) DEFAULT NULL,
  `valise_4_etiquette_3` varchar(100) DEFAULT NULL,
  `v4_e3_Owner` varchar(100) DEFAULT NULL,
  `v4_e3_CR` varchar(5) DEFAULT NULL,
  `valise_4_etiquette_4` varchar(100) DEFAULT NULL,
  `v4_e4_Owner` varchar(100) DEFAULT NULL,
  `v4_e4_CR` varchar(5) DEFAULT NULL,
  `valise_4_etiquette_5` varchar(100) DEFAULT NULL,
  `v4_e5_Owner` varchar(100) DEFAULT NULL,
  `v4_e5_CR` varchar(5) DEFAULT NULL,
  `valise_5_etiquette_1` varchar(100) DEFAULT NULL,
  `v5_e1_Owner` varchar(100) DEFAULT NULL,
  `v5_e1_CR` varchar(5) DEFAULT NULL,
  `valise_5_etiquette_2` varchar(100) DEFAULT NULL,
  `v5_e2_Owner` varchar(100) DEFAULT NULL,
  `v5_e2_CR` varchar(5) DEFAULT NULL,
  `valise_5_etiquette_3` varchar(100) DEFAULT NULL,
  `v5_e3_Owner` varchar(100) DEFAULT NULL,
  `v5_e3_CR` varchar(5) DEFAULT NULL,
  `valise_5_etiquette_4` varchar(100) DEFAULT NULL,
  `v5_e4_Owner` varchar(100) DEFAULT NULL,
  `v5_e4_CR` varchar(5) DEFAULT NULL,
  `valise_5_etiquette_5` varchar(100) DEFAULT NULL,
  `v5_e5_Owner` varchar(100) DEFAULT NULL,
  `v5_e5_CR` varchar(5) DEFAULT NULL,
  `helpTxt` text,
  `helpImg` varchar(100) DEFAULT NULL,
  `helpVideo` varchar(100) DEFAULT NULL,
  `helpAudio` varchar(100) DEFAULT NULL,
  `createur_id` int(11) NOT NULL,
  `date_defi` date DEFAULT NULL,
  `cat1` varchar(50) DEFAULT NULL,
  `cat2` varchar(50) DEFAULT NULL,
  `cat3` varchar(50) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `imgHelpOwner` varchar(100) DEFAULT NULL,
  `imgHelpCR` varchar(5) DEFAULT NULL,
  `videoHelpOwner` varchar(100) DEFAULT NULL,
  `videoHelpCR` varchar(5) DEFAULT NULL,
  `audioHelpOwner` varchar(100) DEFAULT NULL,
  `audioHelpCR` varchar(5) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'classement',
  `remarque` text NOT NULL,
  `etat` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Structure de la table `Documents`
--

CREATE TABLE IF NOT EXISTS `Documents` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `srcName` varchar(100) NOT NULL,
  `lang` varchar(10) NOT NULL,
  `category` smallint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

INSERT INTO `Documents` (`id`, `titre`, `srcName`, `lang`, `category`) VALUES
(1, 'Créer un défi - Aspects juridiques', 'Aspects juridiques.pdf', 'FR', 3),
(4, 'Créer un défi - Boite à outils pour créer un défi', 'Boite à outils pour créer un défi.pdf', 'FR', 2),
(6, 'Créer un défi - Traitement image PAINT', 'Traitement image PAINT.pdf', 'FR', 2),
(7, 'Créer un défi - Traitement Images PHOTOS', 'Traitement Images PHOTOS.pdf', 'FR', 2),
(8, 'Créer un défi - Utilisez la licence Creative Commons Classe', 'Utilisez la licence Creative Commons Classe.pdf', 'FR', 3),
(9, 'Eine Aufgabe erstellen - Bildnutzung', 'Bildnutzung.pdf', 'DE', 3),
(10, 'Eine Aufgabe erstellen - Creative Commons', 'Creative Commons.pdf', 'DE', 3),
(11, 'Eine Aufgabe erstellen - Einverständniserklärung', 'Einverständniserklärung.pdf', 'DE', 3),
(12, 'Eine Aufgabe erstellen - Rechtliche Aspekte', 'Rechtliche Aspekte.pdf', 'DE', 3),
(14, 'Eine Aufgabe erstellen - Toolbox zum Erstellen von Aufgaben', 'Toolbox zum Erstellen von Aufgaben.pdf', 'DE', 2),
(15, '1 Le projet Passe-Partout', '1 Le projet Passe-Partout.pdf', 'FR', 1),
(16, '2 Informations générales Rhin supérieur', '2 Informations générales Rhin supérieur.pdf', 'FR', 1),
(17, '3 Références socle commun et programmes', '3 Références socle commun et programmes.pdf', 'FR', 1),
(19, '1 Das Projekt Weltenbummler', '1 Das Projekt Weltenbummler.pdf', 'DE', 1),
(20, '2 Allg Informationen Oberrhein', '2 Allg Informationen Oberrhein.pdf', 'DE', 1),
(21, '3 Bezug Bildungsplan RP KA', '3 Bezug Bildungsplan RP KA.pdf', 'DE', 1),
(22, '4 Bezug Lehrplan RLP kurz', '4 Bezug Lehrplan RLP kurz.pdf', 'DE', 1),
(23, '5 Bezug Medienkompass und Lehrplan RLP lang', '5 Bezug Medienkompass und Lehrplan RLP lang.pdf', 'DE', 1),
(35, 'Autorisation d''enregistrement de l''image ou de la voix d''une personne majeure', 'Autorisation-captation-image-majeur.pdf', 'FR', 3),
(36, 'Autorisation d''enregistrement de l''image ou de la voix d''une personne mineure', 'Autorisation-captation-image-mineur.pdf', 'FR', 3),
(37, 'Ressources et contact', 'Ressources et Contact.pdf', 'FR', 4),
(38, 'Ressourcen und Kontakt', 'Ressourcen und Kontakt.pdf', 'DE', 4),
(41, 'Antrag Finanzierung Klassenbegegnung', '18 08 30_Antrag_Klassenbegegnung-Demande_Rencontre.docx', 'DE', 4),
(42, 'Demande financement de rencontre de classes', '18 08 30_Antrag_Klassenbegegnung-Demande_Rencontre-0.docx', 'FR', 4),
(53, 'Präsentation Fortbildungen', 'PPT Formation 21.11.18.pdf', 'DE', 1),
(54, 'Présentation formations', 'PPT Formation 21.11.18-0.pdf', 'FR', 1),
(55, 'Challenge Passe-Partout 2019-2020', '1 Challenge Passe-Partout 2019-2020.pdf', 'FR', 4),
(56, 'Challenge Passe-Partout 2019-2020 Règlement', '2 Challenge Passe-Partout Règlement.pdf', 'FR', 4),
(57, 'Challenge Passe-Partout 2019-2020 Grille d''évaluation', '3 Challenge Passe-Partout Grille d''évaluation.pdf', 'FR', 4),
(58, 'Weltenbummler Challenge 2019-2020', '1 Weltenbummler Challenge 2019-2020.pdf', 'DE', 4),
(59, 'Weltenbummler Challenge 2019-2020 Teilnahmebedingungen', '2 Weltenbummler Challenge Bedingungen.pdf', 'DE', 4),
(60, 'Weltenbummler Challenge 2019-2020 Bewertungsbogen', '3 Weltenbummler Challenge Bewertungsbogen.pdf', 'DE', 4),
(61, 'Tipps &amp; Tricks für eine gute Aufgabe', '4 Tipps und Tricks für eine gute Aufgabe.pdf', 'DE', 2),
(62, 'Conseils pour créer un bon défi', '4 Conseils pour créer un bon défi.pdf', 'FR', 2),
(63, 'Bestätigung Klassenbegegnung', 'Bestätigung Klassenbegegnung.pdf', 'DE', 4),
(64, 'Confirmation rencontre de classe', 'Bestätigung Klassenbegegnung-0.pdf', 'FR', 4),
(65, 'Spielregeln', 'Spielregeln Weltenbummler üb.pdf', 'DE', 1),
(66, 'Règles du jeu', 'Règles du jeu nv.pdf', 'FR', 1);


-- --------------------------------------------------------

--
-- Structure de la table `FriseChrono`
--

CREATE TABLE IF NOT EXISTS `FriseChrono` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ed` varchar(10) NOT NULL,
  `langue_defi` varchar(5) NOT NULL,
  `region` varchar(70) DEFAULT NULL,
  `lieu` varchar(40) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `titre_frise` varchar(70) DEFAULT NULL,
  `date_debut` int(11) DEFAULT NULL,
  `date_fin` int(11) DEFAULT NULL,
  `item1_date` int(11) DEFAULT NULL,
  `item1_title` varchar(70) DEFAULT NULL,
  `item1_img` varchar(100) DEFAULT NULL,
  `item1Owner` varchar(100) DEFAULT NULL,
  `item1CR` varchar(5) DEFAULT NULL,
  `item2_date` int(11) DEFAULT NULL,
  `item2_title` varchar(70) DEFAULT NULL,
  `item2_img` varchar(100) DEFAULT NULL,
  `item2Owner` varchar(100) DEFAULT NULL,
  `item2CR` varchar(5) DEFAULT NULL,
  `item3_date` int(11) DEFAULT NULL,
  `item3_title` varchar(70) DEFAULT NULL,
  `item3_img` varchar(100) DEFAULT NULL,
  `item3Owner` varchar(100) DEFAULT NULL,
  `item3CR` varchar(5) DEFAULT NULL,
  `item4_date` int(11) DEFAULT NULL,
  `item4_title` varchar(70) DEFAULT NULL,
  `item4_img` varchar(100) DEFAULT NULL,
  `item4Owner` varchar(100) DEFAULT NULL,
  `item4CR` varchar(5) DEFAULT NULL,
  `item5_date` int(11) DEFAULT NULL,
  `item5_title` varchar(70) DEFAULT NULL,
  `item5_img` varchar(100) DEFAULT NULL,
  `item5Owner` varchar(100) DEFAULT NULL,
  `item5CR` varchar(5) DEFAULT NULL,
  `item6_date` int(11) DEFAULT NULL,
  `item6_title` varchar(70) DEFAULT NULL,
  `item6_img` varchar(100) DEFAULT NULL,
  `item6Owner` varchar(100) DEFAULT NULL,
  `item6CR` varchar(5) DEFAULT NULL,
  `helpTxt` text,
  `helpImg` varchar(100) DEFAULT NULL,
  `helpVideo` varchar(100) DEFAULT NULL,
  `helpAudio` varchar(100) DEFAULT NULL,
  `date_defi` date DEFAULT NULL,
  `createur_id` int(11) NOT NULL DEFAULT '0',
  `cat1` varchar(50) DEFAULT NULL,
  `cat2` varchar(50) DEFAULT NULL,
  `cat3` varchar(50) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `imgHelpOwner` varchar(100) DEFAULT NULL,
  `imgHelpCR` varchar(5) DEFAULT NULL,
  `videoHelpOwner` varchar(100) DEFAULT NULL,
  `videoHelpCR` varchar(5) DEFAULT NULL,
  `audioHelpOwner` varchar(100) DEFAULT NULL,
  `audioHelpCR` varchar(5) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'frise',
  `remarque` text NOT NULL,
  `etat` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Structure de la table `Groupe`
--

CREATE TABLE IF NOT EXISTS `Groupe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tranche_age` varchar(5) DEFAULT NULL,
  `nom_groupe` varchar(40) DEFAULT NULL,
  `id_classe` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `nb_enfant_groupe` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=550 ;

-- --------------------------------------------------------

--
-- Structure de la table `Professeur`
--

CREATE TABLE IF NOT EXISTS `Professeur` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `nom_ecole` varchar(40) DEFAULT NULL,
  `lieu` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=189 ;

-- --------------------------------------------------------

--
-- Structure de la table `QCM`
--

CREATE TABLE IF NOT EXISTS `QCM` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ed` varchar(10) NOT NULL,
  `langue_defi` varchar(5) NOT NULL,
  `region` varchar(70) DEFAULT NULL,
  `lieu` varchar(40) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `titre_question` varchar(75) DEFAULT NULL,
  `question` text,
  `reponse1` varchar(50) DEFAULT NULL,
  `reponse2` varchar(50) DEFAULT NULL,
  `reponse3` varchar(50) DEFAULT NULL,
  `reponse4` varchar(50) DEFAULT NULL,
  `reponse5` varchar(50) DEFAULT NULL,
  `nb_reponse_juste` smallint(10) unsigned DEFAULT NULL,
  `helpTxt` text,
  `helpImg` varchar(100) DEFAULT NULL,
  `helpVideo` varchar(100) DEFAULT NULL,
  `helpAudio` varchar(100) DEFAULT NULL,
  `cat1` varchar(50) DEFAULT NULL,
  `cat2` varchar(50) DEFAULT NULL,
  `cat3` varchar(50) DEFAULT NULL,
  `date_defi` date DEFAULT NULL,
  `createur_id` int(11) NOT NULL DEFAULT '0',
  `adresse` varchar(100) DEFAULT NULL,
  `imgQcmOwner` varchar(100) DEFAULT NULL,
  `imgQcmCR` varchar(5) DEFAULT NULL,
  `imgHelpOwner` varchar(100) DEFAULT NULL,
  `imgHelpCR` varchar(5) DEFAULT NULL,
  `videoHelpOwner` varchar(100) DEFAULT NULL,
  `videoHelpCR` varchar(5) DEFAULT NULL,
  `audioHelpOwner` varchar(100) DEFAULT NULL,
  `audioHelpCR` varchar(5) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'qcm',
  `remarque` text NOT NULL,
  `etat` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=648 ;

-- --------------------------------------------------------

--
-- Structure de la table `Reporting`
--

CREATE TABLE IF NOT EXISTS `Reporting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_reporter` int(10) NOT NULL,
  `full_name_reporter` varchar(100) NOT NULL,
  `email_reporter` varchar(100) NOT NULL,
  `defi_id` int(10) NOT NULL,
  `defi_lieu` varchar(100) NOT NULL,
  `defi_type` varchar(20) NOT NULL,
  `defi_titre` varchar(100) NOT NULL,
  `report_type` varchar(20) NOT NULL,
  `report_desc` text NOT NULL,
  `owner_defi_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Structure de la table `stats_visites`
--

CREATE TABLE IF NOT EXISTS `stats_visites` (
  `ip` varchar(30) NOT NULL,
  `nb_visite` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `TexteTrous`
--

CREATE TABLE IF NOT EXISTS `TexteTrous` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ed` varchar(10) NOT NULL,
  `langue_defi` varchar(5) NOT NULL,
  `region` varchar(70) DEFAULT NULL,
  `lieu` varchar(40) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `titre_question` varchar(70) DEFAULT NULL,
  `question` text,
  `texteAtrou` text,
  `mot1` varchar(50) DEFAULT NULL,
  `mot2` varchar(50) DEFAULT NULL,
  `mot3` varchar(50) DEFAULT NULL,
  `mot4` varchar(50) DEFAULT NULL,
  `mot5` varchar(50) DEFAULT NULL,
  `mot6` varchar(50) DEFAULT NULL,
  `mot7` varchar(50) DEFAULT NULL,
  `mot8` varchar(50) DEFAULT NULL,
  `mot9` varchar(50) DEFAULT NULL,
  `mot10` varchar(50) DEFAULT NULL,
  `helpTxt` text,
  `helpImg` varchar(100) DEFAULT NULL,
  `helpVideo` varchar(100) DEFAULT NULL,
  `helpAudio` varchar(100) DEFAULT NULL,
  `nbMots` smallint(6) DEFAULT NULL,
  `createur_id` int(11) NOT NULL DEFAULT '0',
  `date_defi` date DEFAULT NULL,
  `cat1` varchar(50) DEFAULT NULL,
  `cat2` varchar(50) DEFAULT NULL,
  `cat3` varchar(50) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `imgHelpOwner` varchar(100) DEFAULT NULL,
  `imgHelpCR` varchar(5) DEFAULT NULL,
  `videoHelpOwner` varchar(100) DEFAULT NULL,
  `videoHelpCR` varchar(5) DEFAULT NULL,
  `audioHelpOwner` varchar(100) DEFAULT NULL,
  `audioHelpCR` varchar(5) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'trou',
  `remarque` text NOT NULL,
  `etat` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE IF NOT EXISTS `Utilisateur` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `ed_init` varchar(30) NOT NULL,
  `ed` varchar(30) NOT NULL,
  `position` smallint(5) unsigned NOT NULL DEFAULT '0',
  `de_top` smallint(6) NOT NULL DEFAULT '0',
  `de_left` smallint(6) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL DEFAULT '0',
  `langue` char(2) NOT NULL DEFAULT 'FR',
  `langue_jeu` varchar(5) NOT NULL DEFAULT 'FR',
  `avatar` varchar(20) NOT NULL DEFAULT 'nom_de_l_avatar.png',
  `cat_user` int(11) DEFAULT '1',
  `nb_bonne_reponse` int(11) NOT NULL DEFAULT '0',
  `nb_reponse_langue_voisin` int(11) NOT NULL DEFAULT '0',
  `nb_tour` int(11) NOT NULL DEFAULT '0',
  `nb_lieu_visite` int(11) NOT NULL DEFAULT '0',
  `carte1_visite` int(11) NOT NULL DEFAULT '0',
  `carte2_visite` int(11) NOT NULL DEFAULT '0',
  `carte3_visite` int(11) NOT NULL DEFAULT '0',
  `carte4_visite` int(11) NOT NULL DEFAULT '0',
  `all_carte_visited` int(11) NOT NULL DEFAULT '0',
  `nb_bonne_reponse_ed1` int(11) NOT NULL DEFAULT '0',
  `nb_reponse_langue_voisin_ed1` int(11) NOT NULL DEFAULT '0',
  `nb_tour_ed1` int(11) NOT NULL DEFAULT '0',
  `nb_lieu_visite_ed1` int(11) NOT NULL DEFAULT '0',
  `nb_bonne_reponse_ed2` int(11) NOT NULL DEFAULT '0',
  `nb_reponse_langue_voisin_ed2` int(11) NOT NULL DEFAULT '0',
  `nb_tour_ed2` int(11) NOT NULL DEFAULT '0',
  `nb_lieu_visite_ed2` int(11) NOT NULL DEFAULT '0',
  `nb_bonne_reponse_ed3` int(11) NOT NULL DEFAULT '0',
  `nb_reponse_langue_voisin_ed3` int(11) NOT NULL DEFAULT '0',
  `nb_tour_ed3` int(11) NOT NULL DEFAULT '0',
  `nb_lieu_visite_ed3` int(11) NOT NULL DEFAULT '0',
  `nb_bonne_reponse_ed4` int(11) NOT NULL DEFAULT '0',
  `nb_reponse_langue_voisin_ed4` int(11) NOT NULL DEFAULT '0',
  `nb_tour_ed4` int(11) NOT NULL DEFAULT '0',
  `nb_lieu_visite_ed4` int(11) NOT NULL DEFAULT '0',
  `cle` varchar(32) NOT NULL,
  `actif` int(11) NOT NULL DEFAULT '0',
  `inscription_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1287 ;

-- --------------------------------------------------------

--
-- Structure de la table `VocalTexte`
--

CREATE TABLE IF NOT EXISTS `VocalTexte` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ed` varchar(10) NOT NULL,
  `langue_defi` varchar(5) NOT NULL,
  `region` varchar(70) DEFAULT NULL,
  `lieu` varchar(40) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `titre_question` varchar(70) DEFAULT NULL,
  `question` text,
  `reponse` varchar(50) DEFAULT NULL,
  `mot_cles` varchar(60) DEFAULT NULL,
  `helpTxt` text,
  `helpImg` varchar(100) DEFAULT NULL,
  `helpVideo` varchar(100) DEFAULT NULL,
  `helpAudio` varchar(100) DEFAULT NULL,
  `date_defi` date DEFAULT NULL,
  `createur_id` int(11) NOT NULL DEFAULT '0',
  `cat1` varchar(50) DEFAULT NULL,
  `cat2` varchar(50) DEFAULT NULL,
  `cat3` varchar(50) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `imgHelpOwner` varchar(100) DEFAULT NULL,
  `imgHelpCR` varchar(5) DEFAULT NULL,
  `videoHelpOwner` varchar(100) DEFAULT NULL,
  `videoHelpCR` varchar(5) DEFAULT NULL,
  `audioHelpOwner` varchar(100) DEFAULT NULL,
  `audioHelpCR` varchar(5) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'vocal',
  `remarque` text NOT NULL,
  `etat` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
