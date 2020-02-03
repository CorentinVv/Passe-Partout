
<?php

	//id du défi à supprimer
	$defiId = htmlspecialchars($_POST['idDefi']);
	// type du défi à supprimer
	$defiType = htmlspecialchars($_POST['typeDefi']);

	switch ($defiType) {
		case 'Qcm':
			$imgQcm = $_POST['imgQcm']; 
            $helpImg = $_POST['helpImg'];
            $helpAudio = $_POST['helpAudio'];
            $helpVideo = $_POST['helpVideo'];
            if (is_file("../uploadDefi/defi/".$imgQcm)) {
				unlink("../uploadDefi/defi/".$imgQcm);
			}
			if (is_file("../uploadDefi/aide/img/".$helpImg)) {
				unlink("../uploadDefi/aide/img/".$helpImg);
			}
			if (is_file("../uploadDefi/aide/son/".$helpAudio)) {
				unlink("../uploadDefi/aide/son/".$helpAudio);
			}
			if (is_file("../uploadDefi/aide/video/".$helpVideo)) {
				unlink("../uploadDefi/aide/video/".$helpVideo);
			}
            // le ZIP
            $zipQcm = "QCM".$defiId.".zip";
            if (is_file("../download/QCM/".$zipQcm)) {
				unlink("../download/QCM/".$zipQcm);
			}
			break;
		case 'Trou':
			$helpImg = $_POST['helpImg'];
            $helpAudio = $_POST['helpAudio'];
            $helpVideo = $_POST['helpVideo'];
			if (is_file("../uploadDefi/TexteTrou/aide/img/".$helpImg)) {
				unlink("../uploadDefi/TexteTrou/aide/img/".$helpImg);
			}
			if (is_file("../uploadDefi/TexteTrou/aide/son/".$helpAudio)) {
				unlink("../uploadDefi/TexteTrou/aide/son/".$helpAudio);
			}
			if (is_file("../uploadDefi/TexteTrou/aide/video/".$helpVideo)) {
				unlink("../uploadDefi/TexteTrou/aide/video/".$helpVideo);
			}
            // le ZIP
            $zipTrou = "TexteTrou".$defiId.".zip";
            if (is_file("../download/TexteTrou/".$zipTrou)) {
				unlink("../download/TexteTrou/".$zipTrou);
			}
			break;
		case 'Vocal':
			$helpImg = $_POST['helpImg'];
            $helpAudio = $_POST['helpAudio'];
            $helpVideo = $_POST['helpVideo'];
            if (is_file("../uploadDefi/aide/img/".$helpImg)) {
				unlink("../uploadDefi/aide/img/".$helpImg);
			}
			if (is_file("../uploadDefi/aide/son/".$helpAudio)) {
				unlink("../uploadDefi/aide/son/".$helpAudio);
			}
			if (is_file("../uploadDefi/aide/video/".$helpVideo)) {
				unlink("../uploadDefi/aide/video/".$helpVideo);
			}
            // le ZIP
            $zipVocal = "VocaTxt".$defiId.".zip";
            if (is_file("../download/VocaTxt/".$zipVocal)) {
				unlink("../download/VocaTxt/".$zipVocal);
			}
			break;
		case 'Frise':
			$item1Img = $_POST['item1_img'];
            $item2Img = $_POST['item2_img'];
            $item3Img = $_POST['item3_img'];
            $item4Img = $_POST['item4_img'];
            $item5Img = $_POST['item5_img'];
            $item6Img = $_POST['item6_img'];
			$helpImg = $_POST['helpImg'];
            $helpAudio = $_POST['helpAudio'];
            $helpVideo = $_POST['helpVideo'];
            if (is_file("../uploadDefi/FriseChrono/".$item1Img)) {
				unlink("../uploadDefi/FriseChrono/".$item1Img);
			}
			if (is_file("../uploadDefi/FriseChrono/".$item2Img)) {
				unlink("../uploadDefi/FriseChrono/".$item2Img);
			}
			if (is_file("../uploadDefi/FriseChrono/".$item3Img)) {
				unlink("../uploadDefi/FriseChrono/".$item3Img);
			}
			if (is_file("../uploadDefi/FriseChrono/".$item4Img)) {
				unlink("../uploadDefi/FriseChrono/".$item4Img);
			}
			if (is_file("../uploadDefi/FriseChrono/".$item5Img)) {
				unlink("../uploadDefi/FriseChrono/".$item5Img);
			}
			if (is_file("../uploadDefi/FriseChrono/".$item6Img)) {
				unlink("../uploadDefi/FriseChrono/".$item6Img);
			}

			if (is_file("../uploadDefi/FriseChrono/aide/img/".$helpImg)) {
				unlink("../uploadDefi/FriseChrono/aide/img/".$helpImg);
			}
			if (is_file("../uploadDefi/FriseChrono/aide/son/".$helpAudio)) {
				unlink("../uploadDefi/FriseChrono/aide/son/".$helpAudio);
			}
			if (is_file("../uploadDefi/FriseChrono/aide/video/".$helpVideo)) {
				unlink("../uploadDefi/FriseChrono/aide/video/".$helpVideo);
			}

            // le ZIP
            $zipFrise = "Frise".$defiId.".zip";
            if (is_file("../download/Frise/".$zipFrise)) {
				unlink("../download/Frise/".$zipFrise);
			}
			break;
		case 'Classement':
			// 1
			$valise_1_etiquette_1 = $_POST['valise_1_etiquette_1'];
			$valise_1_etiquette_2 = $_POST['valise_1_etiquette_2'];
			$valise_1_etiquette_3 = $_POST['valise_1_etiquette_3'];
			$valise_1_etiquette_4 = $_POST['valise_1_etiquette_4'];
			$valise_1_etiquette_5 = $_POST['valise_1_etiquette_5'];
			// 2
			$valise_2_etiquette_1 = $_POST['valise_2_etiquette_1'];
			$valise_2_etiquette_2 = $_POST['valise_2_etiquette_2'];
			$valise_2_etiquette_3 = $_POST['valise_2_etiquette_3'];
			$valise_2_etiquette_4 = $_POST['valise_2_etiquette_4'];
			$valise_2_etiquette_5 = $_POST['valise_2_etiquette_5'];
			// 3
			$valise_3_etiquette_1 = $_POST['valise_3_etiquette_1'];
			$valise_3_etiquette_2 = $_POST['valise_3_etiquette_2'];
			$valise_3_etiquette_3 = $_POST['valise_3_etiquette_3'];
			$valise_3_etiquette_4 = $_POST['valise_3_etiquette_4'];
			$valise_3_etiquette_5 = $_POST['valise_3_etiquette_5'];
			// 4
			$valise_4_etiquette_1 = $_POST['valise_4_etiquette_1'];
			$valise_4_etiquette_2 = $_POST['valise_4_etiquette_2'];
			$valise_4_etiquette_3 = $_POST['valise_4_etiquette_3'];
			$valise_4_etiquette_4 = $_POST['valise_4_etiquette_4'];
			$valise_4_etiquette_5 = $_POST['valise_4_etiquette_5'];
			// 5
			$valise_5_etiquette_1 = $_POST['valise_5_etiquette_1'];
			$valise_5_etiquette_2 = $_POST['valise_5_etiquette_2'];
			$valise_5_etiquette_3 = $_POST['valise_5_etiquette_3'];
			$valise_5_etiquette_4 = $_POST['valise_5_etiquette_4'];
			$valise_5_etiquette_5 = $_POST['valise_5_etiquette_5'];
			$helpImg = $_POST['helpImg'];
            $helpAudio = $_POST['helpAudio'];
            $helpVideo = $_POST['helpVideo'];
            // 1
            if (is_file("../uploadDefi/Classement/".$valise_1_etiquette_1)) {
				unlink("../uploadDefi/Classement/".$valise_1_etiquette_1);
			}
			if (is_file("../uploadDefi/Classement/".$valise_1_etiquette_2)) {
				unlink("../uploadDefi/Classement/".$valise_1_etiquette_2);
			}
			if (is_file("../uploadDefi/Classement/".$valise_1_etiquette_3)) {
				unlink("../uploadDefi/Classement/".$valise_1_etiquette_3);
			}
			if (is_file("../uploadDefi/Classement/".$valise_1_etiquette_4)) {
				unlink("../uploadDefi/Classement/".$valise_1_etiquette_4);
			}
			if (is_file("../uploadDefi/Classement/".$valise_1_etiquette_5)) {
				unlink("../uploadDefi/Classement/".$valise_1_etiquette_5);
			}
            // 2
            if (is_file("../uploadDefi/Classement/".$valise_2_etiquette_1)) {
				unlink("../uploadDefi/Classement/".$valise_2_etiquette_1);
			}
			if (is_file("../uploadDefi/Classement/".$valise_2_etiquette_2)) {
				unlink("../uploadDefi/Classement/".$valise_2_etiquette_2);
			}
			if (is_file("../uploadDefi/Classement/".$valise_2_etiquette_3)) {
				unlink("../uploadDefi/Classement/".$valise_2_etiquette_3);
			}
			if (is_file("../uploadDefi/Classement/".$valise_2_etiquette_4)) {
				unlink("../uploadDefi/Classement/".$valise_2_etiquette_4);
			}
			if (is_file("../uploadDefi/Classement/".$valise_2_etiquette_5)) {
				unlink("../uploadDefi/Classement/".$valise_2_etiquette_5);
			}
            // 3
            if (is_file("../uploadDefi/Classement/".$valise_3_etiquette_1)) {
				unlink("../uploadDefi/Classement/".$valise_3_etiquette_1);
			}
			if (is_file("../uploadDefi/Classement/".$valise_3_etiquette_2)) {
				unlink("../uploadDefi/Classement/".$valise_3_etiquette_2);
			}
			if (is_file("../uploadDefi/Classement/".$valise_3_etiquette_3)) {
				unlink("../uploadDefi/Classement/".$valise_3_etiquette_3);
			}
			if (is_file("../uploadDefi/Classement/".$valise_3_etiquette_4)) {
				unlink("../uploadDefi/Classement/".$valise_3_etiquette_4);
			}
			if (is_file("../uploadDefi/Classement/".$valise_3_etiquette_5)) {
				unlink("../uploadDefi/Classement/".$valise_3_etiquette_5);
			}
            // 4
            if (is_file("../uploadDefi/Classement/".$valise_4_etiquette_1)) {
				unlink("../uploadDefi/Classement/".$valise_4_etiquette_1);
			}
			if (is_file("../uploadDefi/Classement/".$valise_4_etiquette_2)) {
				unlink("../uploadDefi/Classement/".$valise_4_etiquette_2);
			}
			if (is_file("../uploadDefi/Classement/".$valise_4_etiquette_3)) {
				unlink("../uploadDefi/Classement/".$valise_4_etiquette_3);
			}
			if (is_file("../uploadDefi/Classement/".$valise_4_etiquette_4)) {
				unlink("../uploadDefi/Classement/".$valise_4_etiquette_4);
			}
			if (is_file("../uploadDefi/Classement/".$valise_4_etiquette_5)) {
				unlink("../uploadDefi/Classement/".$valise_4_etiquette_5);
			}
            // 5
            if (is_file("../uploadDefi/Classement/".$valise_5_etiquette_1)) {
				unlink("../uploadDefi/Classement/".$valise_5_etiquette_1);
			}
			if (is_file("../uploadDefi/Classement/".$valise_5_etiquette_2)) {
				unlink("../uploadDefi/Classement/".$valise_5_etiquette_2);
			}
			if (is_file("../uploadDefi/Classement/".$valise_5_etiquette_3)) {
				unlink("../uploadDefi/Classement/".$valise_5_etiquette_3);
			}
			if (is_file("../uploadDefi/Classement/".$valise_5_etiquette_4)) {
				unlink("../uploadDefi/Classement/".$valise_5_etiquette_4);
			}
			if (is_file("../uploadDefi/Classement/".$valise_5_etiquette_5)) {
				unlink("../uploadDefi/Classement/".$valise_5_etiquette_5);
			}

			if (is_file("../uploadDefi/Classement/aide/img/".$helpImg)) {
				unlink("../uploadDefi/Classement/aide/img/".$helpImg);
			}
			if (is_file("../uploadDefi/Classement/aide/son/".$helpAudio)) {
				unlink("../uploadDefi/Classement/aide/son/".$helpAudio);
			}
			if (is_file("../uploadDefi/Classement/aide/video/".$helpVideo)) {
				unlink("../uploadDefi/Classement/aide/video/".$helpVideo);
			}
            // le ZIP
            $zipClassement = "Classement".$defiId.".zip";
            if (is_file("../download/Classement/".$zipClassement)) {
				unlink("../download/Classement/".$zipClassement);
			}
			break;
	}

	//--------------------1--------------------------//

?>