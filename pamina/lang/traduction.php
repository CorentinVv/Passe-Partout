<?php 

	$lang = $_SESSION['user']['langue'];
	// $lang = 'DE';

	$translation = array(
		"commencer" => array(
			"FR" => "Commencer",
			"DE" => "Beginnen"
		),
		"gestion_classes" => array(
			"FR" => "Gestion des classes",
			"DE" => "Lerngruppen verwalten"
		),
		"gestion_defis" => array(
			"FR" => "Gestion des défis",
			"DE" => "Aufgaben verwalten"
		),
		"classement" => array(
			"FR" => "Classement",
			"DE" => "Wertung"
		),
		"gestion_compte" => array(
			"FR" => "Gestion de compte",
			"DE" => "Nutzerkonto verwalten"
		),
		"deconnexion" => array(
			"FR" => "Déconnexion",
			"DE" => "Abmelden"
		),
		/* *************** */
		"ajouter_defi" => array(
			"FR" => "Ajouter un défi",
			"DE" => "Eine Aufgabe hinzufügen"
		),
		"modifier_defi" => array(
			"FR" => "Modifier un défi",
			"DE" => "Eine Aufgabe verändern"
		),
		"defi_a_revoir" => array(
			"FR" => "Défis à revoir",
			"DE" => "Aufgabe überarbeiten"
		),
		"moderer_defi" => array(
			"FR" => "Modérer les défis",
			"DE" => "Aufgaben moderieren"
		),
		/* *************** */
		"qcm" => array(
			"FR" => "Choix multiples",
			"DE" => "Multiple Choice Fragen"
		),
		"texte_a_trou" => array(
			"FR" => "Texte à trous",
			"DE" => "Lückentext"
		),
		"reconnaissance_vocale" => array(
			"FR" => "Reconnaissance vocale",
			"DE" => "Stimmerkennung"
		),
		"frise_chronologique" => array(
			"FR" => "Frise chronologique",
			"DE" => "Zeitstrahl"
		),
		"classement_thematique" => array(
			"FR" => "Classement thématique",
			"DE" => "thematische Einordnung"
		),
		"retour" => array(
			"FR" => "Retour",
			"DE" => "Zurück"
		),
		"accueil" => array(
			"FR" => "Accueil",
			"DE" => "Startseite"
		),
		"choisissez_eurodistrict" => array(
			"FR" => "Cliquez sur la carte pour choisir l'eurodistrict concerné par votre question",
			"DE" => "Klicken Sie auf die Karte, um den von Ihrer Frage betroffenen Eurodistrikt auszuwählen"
		),
		"choisissez_eurodistrict_classe" => array(
			"FR" => "Choisissez un eurodistrict ci-dessous",
			"DE" => "Wählen Sie einen Eurodistrikt"
		),
		"choisissez_eurodistrict_groupe" => array(
			"FR" => "Cliquez sur la carte pour choisir l'eurodistrict sur lequel vos élèves vont commencer à jouer",
			"DE" => "Klicken Sie auf die Karte, um den Eurodistrikt auszuwählen, in dem Ihre Schüler das Spiel beginnen"
		),
		"classement_eurodistrict" => array(
			"FR" => "Le score de votre classe sera intégré au classement de l’eurodistrict choisi.",
			"DE" => "Das Spielergebnis Ihrer Klasse wird in dem ausgewählten Eurodistrikt übertragen."
		),
		"langue_defi" => array(
			"FR" => "Langue du défi",
			"DE" => "Sprache der Aufgabe"
		),
		"question_culture_generale" => array(
			"FR" => "Question de culture générale",
			"DE" => "Allgemeine Frage zur Region"
		),
		"region" => array(
			"FR" => "Région",
			"DE" => "Region"
		),
		"categorie_defi" => array(
			"FR" => "Catégorie du défi",
			"DE" => "Kategorie der Aufgabe"
		),
		"type_defi" => array(
			"FR" => "Type du défi",
			"DE" => "Typ der Aufgabe"
		),
		"titre_question" => array(
			"FR" => "Titre de la question",
			"DE" => "Titel der Frage"
		),
		"question" => array(
			"FR" => "Question",
			"DE" => "Frage"
		),
		"reponse" => array(
			"FR" => "Réponse",
			"DE" => "Antwort"
		),
		"numero_reponse_correcte" => array(
			"FR" => "Numéro de la réponse correcte",
			"DE" => "Nummer der richtigen Antwort"
		),
		"image_illustration" => array(
			"FR" => "Image d\'illustration",
			"DE" => "Illustration"
		),
		"image_illustration2" => array(
			"FR" => "Image d'illustration",
			"DE" => "Illustration"
		),
		"choisissez_fichier" => array(
			"FR" => "Choisissez un fichier",
			"DE" => "Eine Datei wählen"
		),
		"aucun_fichier_choisi" => array(
			"FR" => "Aucun fichier choisi",
			"DE" => "Keine Datei gewählt"
		),
		"proprietaire_image_illustration_defi" => array(
			"FR" => "Propriétaire de l\'image d\'illustration du défi",
			"DE" => "Autor der Illustration der Aufgabe"
		),
		"proprietaire_image_illustration_defi2" => array(
			"FR" => "Propriétaire de l'image d'illustration du défi",
			"DE" => "Autor der Illustration der Aufgabe"
		),
		"aide_au_defi" => array(
			"FR" => "Aide au défi",
			"DE" => "Hilfe für die Aufgaben"
		),
		"texte_aide_defi" => array(
			"FR" => "Texte d\'aide au défi",
			"DE" => "Hilfstext für die Aufgabe"
		),
		"texte_aide_defi2" => array(
			"FR" => "Texte d'aide au défi",
			"DE" => "Hilfstext für die Aufgabe"
		),
		"taille_de_texte_lisibe" => array(
			"FR" => "Pensez à mettre votre texte en taille 18 pour qu\'il soit bien lisible",
			"DE" => "Den Text in Größe 18 einfügen, damit er gut lesbar ist."
		),
		"texte_seulement" => array(
			"FR" => "Texte seulement ! Voir les champs ci dessous pour les images/vidéos/audios",
			"DE" => "Nur Texte! Für Bilder/Videos/Audio untenstehende Felder benutzen."
		),
		"adresse_ou_nom_exacte_du_lieu" => array(
			"FR" => "Adresse ou nom exact du lieu",
			"DE" => "Genaue Adresse oder Name des Ortes"
		),
		"pas_de_carte" => array(
			"FR" => "Si vous ne voulez pas de carte, laissez ce champ vide.",
			"DE" => "Freilassen, wenn keine Karte gewünscht ist"
		),
		"image_aide_defi" => array(
			"FR" => "Image d\'aide au défi",
			"DE" => "Hilfsbild für die Aufgabe"
		),
		"image_aide_defi2" => array(
			"FR" => "Image d'aide au défi",
			"DE" => "Hilfsbild für die Aufgabe"
		),
		"prop_image_aide_defi" => array(
			"FR" => "Propriétaire de l\'image d\'aide au défi",
			"DE" => "Autor des Hilfsbildes für die Aufgabe"
		),
		"prop_image_aide_defi2" => array(
			"FR" => "Propriétaire de l'image d'aide au défi",
			"DE" => "Autor des Hilfsbildes für die Aufgabe"
		),
		"video_aide_defi" => array(
			"FR" => "Vidéo d\'aide au défi",
			"DE" => "Hilfsvideo für die Aufgabe"
		),
		"video_aide_defi2" => array(
			"FR" => "Vidéo d'aide au défi",
			"DE" => "Hilfsvideo für die Aufgabe"
		),
		"prop_video_aide_defi" => array(
			"FR" => "Propriétaire de la vidéo d\'aide au défi",
			"DE" => "Autor des Hilfsvideos für die Aufgabe"
		),
		"prop_video_aide_defi2" => array(
			"FR" => "Propriétaire de la vidéo d'aide au défi",
			"DE" => "Autor des Hilfsvideos für die Aufgabe"
		),
		"audio_aide_defi" => array(
			"FR" => "Fichier audio d\'aide au défi",
			"DE" => "Hilfs-Audiodatei für die Aufgaben"
		),
		"audio_aide_defi2" => array(
			"FR" => "Fichier audio d'aide au défi",
			"DE" => "Hilfs-Audiodatei für die Aufgaben"
		),
		"prop_audio_defi" => array(
			"FR" => "Propriétaire du fichier audio d\'aide au défi",
			"DE" => "Autor der Hilfs-Audiodatei für die Aufgabe"
		),
		"prop_audio_defi2" => array(
			"FR" => "Propriétaire du fichier audio d'aide au défi",
			"DE" => "Autor der Hilfs-Audiodatei für die Aufgabe"
		),
		"droit_prop_intellect" => array(
			"FR" => "Je déclare disposer des droits de propriété intellectuelle pour les documents que je publie dans ce défi.",
			"DE" => "Ich erkläre, dass ich die Urheberrechte für die Dokumente besitze, die ich in dieser Aufgabe veröffentliche."
		),
		"droit_image" => array(
			"FR" => "Je déclare disposer des autorisations de droit à l’image pour les photographies ou vidéos dans lesquelles apparaissent des personnes.",
			"DE" => "Ich erkläre, dass ich für die Fotos und Videos, auf bzw. in denen Personen zu sehen sind, die entsprechende Nutzungsrechte besitze."
		),
		"previsualisation" => array(
			"FR" => "Prévisualisation",
			"DE" => "Vorschau"
		),
		"valider" => array(
			"FR" => "Valider",
			"DE" => "Bestätigen"
		),
		"exemple_de_reponse" => array(
			"FR" => "exemple de réponse",
			"DE" => "Beispiel für eine Antwort"
		),
		"pas_de_point_virgule" => array(
			"FR" => "Ne pas mettre de point ni de virgule.",
			"DE" => "Weder Punkt noch Komma setzen."
		),
		"pas_de_point_virgule2" => array(
			"FR" => "Ne pas mettre de point ni de virgule.",
			"DE" => "Weder Punkt noch Komma setzen."
		),
		"mots_cles" => array(
			"FR" => "Mots clés",
			"DE" => "Schlüsselwörter"
		),
		"laissez_un_espace" => array(
			"FR" => "Laissez un espace entre chaques mots clés.",
			"DE" => "Ein Leerzeichen zwischen den Schlüsselwörtern lassen"
		),
		"date_debut_frise" => array(
			"FR" => "Date de début de frise",
			"DE" => "Datum für den Beginn des Zeitstrahls"
		),
		"date_fin_frise" => array(
			"FR" => "Date de fin de frise",
			"DE" => "Datum für das Ende des Zeitstrahls"
		),
		"titre_frise" => array(
			"FR" => "Titre de la frise",
			"DE" => "Titel des Zeitstrahls"
		),
		"evenement_n" => array(
			"FR" => "Evenement n°",
			"DE" => "Ereignis N°"
		),
		"nom_evenement" => array(
			"FR" => "Nom de l\'événement",
			"DE" => "Name des Ereignisses"
		),
		"nom_evenement2" => array(
			"FR" => "Nom de l'événement",
			"DE" => "Name des Ereignisses"
		),
		"date_evenement" => array(
			"FR" => "Date de l\'événement",
			"DE" => "Datum des Ereignisses"
		),
		"date_evenement2" => array(
			"FR" => "Date de l'événement",
			"DE" => "Datum des Ereignisses"
		),
		"vignette_evenement" => array(
			"FR" => "Vignette de l\'événement",
			"DE" => "Miniaturbild für das Ereignis"
		),
		"vignette_evenement2" => array(
			"FR" => "Vignette de l'événement",
			"DE" => "Miniaturbild für das Ereignis"
		),
		"exemple_input" => array(
			"FR" => "Ceci est INPUT1 exemple de texte à INPUT2",
			"DE" => "Das ist INPUT1, Textbeispiel bei INPUT 2"
		),
		"remplacer_mot_input" => array(
			"FR" => "Remplacer les mots à trouver par INPUT1, puis INPUT2 et ainsi de suite.",
			"DE" => "Die zu findenden Wörter durch INPUT1, dann INPUT2 usw. ersetzen"
		),
		"nb_mot_input" => array(
			"FR" => "Vous devez mettre entre trois et six mots",
			"DE" => "Sie sollten zwischen drei und fünf Wörtern eingeben"
		),
		"nombre_de_categorie" => array(
			"FR" => "Nombre de catégorie",
			"DE" => "Anzahl der Kategorien"
		),
		"type_etiquette" => array(
			"FR" => "Type d\'étiquette",
			"DE" => "Miniaturbildtyp"
		),
		"type_etiquette2" => array(
			"FR" => "Type d'étiquette",
			"DE" => "Miniaturbildtyp"
		),
		"groupe_de_mots" => array(
			"FR" => "Groupe de mots",
			"DE" => "Wörtergruppe"
		),
		"image" => array(
			"FR" => "Image",
			"DE" => "Bild"
		),
		/* *************** */
		"mes_documents" => array(
			"FR" => "Mes documents",
			"DE" => "Meine Dokumente"
		),
		"gerer_mes_parametres" => array(
			"FR" => "Gérer mes paramètres",
			"DE" => "Meine Einstellungen ändern"
		),
		"mon_compte" => array(
			"FR" => "Mon compte",
			"DE" => "Mein Konto"
		),
		"nom_utilisateur" => array(
			"FR" => "Nom d'utilisateur",
			"DE" => "Benutzername"
		),
		"ancien_mot_de_passe" => array(
			"FR" => "Ancien mot de passe",
			"DE" => "Altes Passwort"
		),
		"nouveau_mot_de_passe" => array(
			"FR" => "Nouveau mot de passe",
			"DE" => "Neues Passwort"
		),
		"confirmer_mot_de_passe" => array(
			"FR" => "Confirmer votre mot de passe",
			"DE" => "Passwort bestätigen"
		),
		/* *************** */
		"signaler_une_erreur" => array(
			"FR" => "Signaler une erreur",
			"DE" => "Einen Fehler melden"
		),
		"dwl_html" => array(
			"FR" => "Télécharger en html 5 pour une consultation hors-ligne",
			"DE" => "In html5 herunterladen, um es offline ansehen zu können"
		),
		"gestion_classes_groupes" => array(
			"FR" => "Gestion des classes et des groupes",
			"DE" => "Verwaltung der Klassen oder Lerngruppen"
		),
		"ajouter_classe_groupe" => array(
			"FR" => "Ajouter une classe ou un groupe",
			"DE" => "Eine Klasse oder Lerngruppe hinzufügen"
		),
		"ajouter_classe" => array(
			"FR" => "Ajouter une classe",
			"DE" => "Eine Klasse hinfügen"
		),
		"ajouter_classe_warning" => array(
			"FR" => "Veuillez ajouter une classe avant d'ajouter un groupe",
			"DE" => "Bitte fügen sie erst eine Klasse hinzu, bevor Sie eine Gruppe hinzufügen"
		),
		"nom_classe" => array(
			"FR" => "Nom de la classe",
			"DE" => "Name der Klasse"
		),
		"nombre_enfants" => array(
			"FR" => "Nombre d\'enfants",
			"DE" => "Anzahl der Kinder"
		),
		"nombre_enfants2" => array(
			"FR" => "Nombre d'enfants",
			"DE" => "Anzahl der Kinder"
		),
		"ajouter_groupe" => array(
			"FR" => "Ajouter un groupe",
			"DE" => "Eine Lerngruppe hinzufügen"
		),
		"identifiant" => array(
			"FR" => "Identifiant",
			"DE" => "Benutzername"
		),
		"mot_de_passe" => array(
			"FR" => "Mot de passe",
			"DE" => "Passwort"
		),
		"confirmation_mot_de_passe" => array(
			"FR" => "Confirmation du mot de passe",
			"DE" => "Bestätigung des Passworts"
		),
		"nom_groupe" => array(
			"FR" => "Nom du groupe",
			"DE" => "Name der Gruppe"
		),
		"nombre_enfants_groupe" => array(
			"FR" => "Nombre d\'enfants dans le groupe",
			"DE" => "Anzahl der Kinder in der Gruppe"
		),
		"nombre_enfants_groupe2" => array(
			"FR" => "Nombre d'enfants dans le groupe",
			"DE" => "Anzahl der Kinder in der Gruppe"
		),
		"classe" => array(
			"FR" => "Classe",
			"DE" => "Klasse"
		),
		"groupe" => array(
			"FR" => "Groupe",
			"DE" => "Gruppe"
		),
		"score" => array(
			"FR" => "Score",
			"DE" => "Punkte"
		),
		"tranche_age_groupe" => array(
			"FR" => "Tranche d'âge du groupe",
			"DE" => "Altersklasse der Gruppe"
		),
		"langue_maternelle" => array(
			"FR" => "Langue maternelle",
			"DE" => "Muttersprache"
		),
		"langue_jeu" => array(
			"FR" => "Langue de jeu",
			"DE" => "Spielsprache"
		),
		"choix_pion" => array(
			"FR" => "Choix du pion",
			"DE" => "Figurenwahl"
		),
		"mes_classes" => array(
			"FR" => "Mes classes",
			"DE" => "Meine Klassen"
		),
		"mes_groupes" => array(
			"FR" => "Mes groupes",
			"DE" => "Meine Gruppen"
		),

		"titre" => array(
			"FR" => "Titre",
			"DE" => "Titel"
		),
		"download" => array(
			"FR" => "Télécharger",
			"DE" => "Herunterladen"
		),
		"oui" => array(
			"FR" => "Oui",
			"DE" => "Ja"
		),
		"non" => array(
			"FR" => "Non",
			"DE" => "Nicht"
		),
		"proprietaire_image" => array(
			"FR" => "Propriétaire de l\'image",
			"DE" => "Autor der Illustration"
		),
		"proprietaire_image2" => array(
			"FR" => "Propriétaire de l'image",
			"DE" => "Autor der Illustration"
		),
		"categorie" => array(
			"FR" => "Catégorie",
			"DE" => "Kategorie"
		),
		"vignette" => array(
			"FR" => "Vignette",
			"DE" => "Miniaturbild"
		),
		"nom" => array(
			"FR" => "Nom",
			"DE" => "Nachname"
		),
		"prenom" => array(
			"FR" => "Prénom",
			"DE" => "Vorname"
		),
		"utilisateur" => array(
			"FR" => "Utilisateurs",
			"DE" => "Nutzer"
		),
		"visites" => array(
			"FR" => "Visites",
			"DE" => "Zugriffe"
		),
		"mixte" => array(
			"FR" => "Mixte",
			"DE" => "Gemischt"
		),
		"lieu" => array(
			"FR" => "Lieu",
			"DE" => "Ort"
		),
		"mot" => array(
			"FR" => "Mot",
			"DE" => "Wort"
		),
		"supprimer_classe" => array(
			"FR" => "Supprimer une classe",
			"DE" => "Eine Klasse löschen"
		),
		"warning_supprimer_classe" => array(
			"FR" => "Attention la suppression d'une classe entraine la suppression de tous les groupes associés à celle ci !",
			"DE" => "Achtung, beim Löschen einer Klasse werden alle Gruppen dieser Klasse gelöscht!"
		),
		"annuler" => array(
			"FR" => "Annuler",
			"DE" => "Abbrechen"
		),
		"supprimer" => array(
			"FR" => "Supprimer",
			"DE" => "Löschen"
		),
		"preview_defi" => array(
			"FR" => "Prévisualisation du défi",
			"DE" => "Vorschau der Aufgabe"
		),
		"preview_defi" => array(
			"FR" => "Prévisualisation du défi",
			"DE" => "Vorschau der Aufgabe"
		),
		"fermer" => array(
			"FR" => "Fermer",
			"DE" => "Schließen"
		),
		"date" => array(
			"FR" => "Date",
			"DE" => "Datum"
		),
		"liste_defi" => array(
			"FR" => "Liste des défis",
			"DE" => "Liste der Aufgaben"
		),
		"recherche" => array(
			"FR" => "Recherche",
			"DE" => "Suche"
		),
		"recherche_titre" => array(
			"FR" => "Rechercher un titre",
			"DE" => "Einen Aufgabentitel suchen"
		),
		"choisissez_une_categorie" => array(
			"FR" => "Choisissez une catégorie de défis, pour les faire apparaitre",
			"DE" => "Wählt einen Aufgabentyp aus, damit die Aufgaben angezeigt werden"
		),
		"recherche_lieu" => array(
			"FR" => "Rechercher un lieu",
			"DE" => "Einen Ort suchen"
		),
		"difficulte" => array(
			"FR" => "Difficulté du défi",
			"DE" => "Schwierigkeitsgrad der Aufgabe"
		),
		"ans" => array(
			"FR" => "ans",
			"DE" => "Jahre"
		),
		"infoMediaDefiTitre" => array(
			"FR" => "Taille et format des médias dans les formulaires de création/modification de défis.",
			"DE" => "Größe und Format der Mediendateien in den Formularen zum Erstellen/Bearbeiten von Aufgaben"
		),
		"infoMediaDefiLi1" => array(
			"FR" => "Les images ne doivent pas dépasser 1Mo et doivent être aux formats png ou jpg (.png/.PNG/.jpg/.JPG)",
			"DE" => "Bilddateien dürfen nicht größer als 1MB sein und müssen das Format png oder jpg haben (.png/.PNG/.jpg/.JPG)."
		),
		"infoMediaDefiLi2" => array(
			"FR" => "Les vidéos ne doivent pas dépasser 50Mo et doivent être au format mp4 (.mp4)",
			"DE" => "Videos dürfen nicht größer als 50MB sein und müssen das Format mp4 haben (.mp4)."
		),
		"infoMediaDefiLi3" => array(
			"FR" => "Les fichiers audio ne doivent pas dépasser 15Mo et doivent être au format mp3 (.mp3)",
			"DE" => "Audiodateien dürfen nicht größer als 15MB sein und müssen das Format mp3 haben (.mp3)."
		),
		"infoMediaDefiMax" => array(
			"FR" => "Le poids cumulé des fichiers est limité à 120Mo !",
			"DE" => "Die Gesamtgröße aller Dateien ist auf 120MB begrenzt!"
		),
		"infoMediaDefiFileName" => array(
			"FR" => "Les noms des fichiers téléchargés ne doivent pas avoir d’accents, espaces ou caractères spéciaux (p.ex. lenigme_de_Herxheim.jpg au lieu de l’énigme de Herxheim.jpg).",
			"DE" => "Die Namen der hochgeladenen Dokumente dürfen keine Akzente, Leer- oder Sonderzeichen enthalten (z.B. schloss_karlsruhe_4b.jpg anstelle von schloss karlsruhe 4b.jpg)."
		),
		"catDoc1" => array(
			"FR" => "Cadre général du jeu",
			"DE" => "Allgemeiner Projektrahmen"
		),
		"catDoc2" => array(
			"FR" => "Créer un défi avec sa classe",
			"DE" => "Mit der Klasse neue Aufgaben erstellen"
		),
		"catDoc3" => array(
			"FR" => "Le droit et la création de défis",
			"DE" => "Rechtliche Aspekte beim Erstellen neuer Aufgaben"
		),
		"catDoc4" => array(
			"FR" => "Ressources complémentaires et contacts",
			"DE" => "Weiterführende Ressourcen und Kontakte"
		),
		"profValDefi" => array(
			"FR" => "Vous avez un défi à valider",
			"DE" => "Sie müssen eine Aufgabe freischalten"
		),
		"groupModifDefi" => array(
			"FR" => "Vous avez un défi à modifier",
			"DE" => "Ihr müsst eine Aufgabe überarbeiten"
		),
		"moderationDefi" => array(
			"FR" => "Modération des défis",
			"DE" => "Moderation der Aufgaben"
		),
		"detailDuDefi" => array(
			"FR" => "Détail du défi n°",
			"DE" => "Detail der Aufgaben Nummer "
		),
		"publierLeDefi" => array(
			"FR" => "Publier le défi",
			"DE" => "Die Aufgabe veröffentlichen"
		),
		"aRevoir" => array(
			"FR" => "A revoir",
			"DE" => "Zu überarbeiten"
		),
		"remarque" => array(
			"FR" => "Remarque",
			"DE" => "Anmerkung"
		),
		"envoyer" => array(
			"FR" => "Envoyer",
			"DE" => "Abschicken"
		),
		"date_de_creation" => array(
			"FR" => "Date de création",
			"DE" => "Erstelldatum"
		),
		"defi_bien_publie" => array(
			"FR" => "Le défi a bien été publié.",
			"DE" => "Die Aufgabe wurde veröffentlicht."
		),
		"defi_est_a_revoir" => array(
			"FR" => "Le défi est à revoir.",
			"DE" => "Die Aufgabe muss überarbeitet werden."
		),
		"erreur" => array(
			"FR" => "Erreur",
			"DE" => "Fehler"
		)
	);

	$thesaurus = array(
		"cat1" => array(
			"FR" => "Science et technologie",
			"DE" => "Natur und Technik"
		),
			"cat1item1" => array(
				"FR" => "Nature",
				"DE" => "Natur"
			),
			"cat1item2" => array(
				"FR" => "Energie",
				"DE" => "Energie"
			),
			"cat1item3" => array(
				"FR" => "Matières et objets techniques",
				"DE" => "Materialien und Eigenschaften"
			),
		"cat2" => array(
			"FR" => "Histoire et Géographie",
			"DE" => "Raum und Zeit"
		),
			"cat2item1" => array(
				"FR" => "Vivre dans l'espace du Rhin supérieur",
				"DE" => "Gemeinsam leben am Oberrhein"
			),
			"cat2item2" => array(
				"FR" => "Se déplacer",
				"DE" => "Mobilität und Verkehr"
			),
			"cat2item3" => array(
				"FR" => "Caractériser le lieu de vie",
				"DE" => "Orientierung im Raum"
			),
			"cat2item4" => array(
				"FR" => "Passé, présent, avenir",
				"DE" => "Vergangenheit, Gegenwart, Zukunft"
			),
		"cat3" => array(
			"FR" => "Arts et culture",
			"DE" => "Kunst und Kultur"
		),
			"cat3item1" => array(
				"FR" => "Arts visuels",
				"DE" => "Kunst"
			),
			"cat3item2" => array(
				"FR" => "Musique",
				"DE" => "Musik"
			),
			"cat3item3" => array(
				"FR" => "Littérature",
				"DE" => "Literatur"
			),
			"cat3item4" => array(
				"FR" => "Culture et interculturalité",
				"DE" => "kulturelle Kompetenz"
			),
		"cat4" => array(
			"FR" => "Sports et loisirs",
			"DE" => "Sport und Freizeit"
		)
	);

	// echo "<pre>";
	// print_r($translation);
	// echo "</pre>";

?>