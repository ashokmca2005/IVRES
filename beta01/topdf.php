<?php
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}

	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
    require_once(SITE_CLASSES_PATH."fpdf.php");
	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	
	//$usersObj->CheckUserLogin();


    function convertPixelsToMm($px, $dpi)
    {
        $inches = $px / $dpi;
        $cm     = $inches * 2.54;
        $mm     = $cm * 10;

        return $mm;
    }

	$headerBanner  		 = "images/print-property-images/header.jpg";

	$property_id 		= $_GET['pid'];
//	$property_id 		= 1;
	$propertyInfo	= $propertyObj->fun_getPropertyInfo($property_id);
	if(count($propertyInfo) > 0){
		$property_name 			= ucwords($propertyInfo['property_name']);
		$property_title 		= ucfirst($propertyInfo['property_title']);
		$property_type  		= $propertyInfo['property_type'];
		$catering_type			= $propertyInfo['catering_type'];
		$property_summary		= ucfirst($propertyInfo['property_summary']);
		$total_beds				= $propertyInfo['total_beds'];
		$ensuite_beds			= $propertyInfo['ensuite_beds'];
		$scomfort_beds			= $propertyInfo['scomfort_beds'];
		$double_beds			= $propertyInfo['double_beds'];
		$single_beds			= $propertyInfo['single_beds'];
		$sofa_beds				= $propertyInfo['sofa_beds'];
		$bed_notes				= ucfirst($propertyInfo['bed_notes']);

		$total_bathrooms		= $propertyInfo['total_bathrooms'];
		$ensuite_baths			= $propertyInfo['ensuite_baths'];
		$shower_baths			= $propertyInfo['shower_baths'];
		$baths					= $propertyInfo['baths'];
		$toilets				= $propertyInfo['toilets'];
		$bath_notes				= ucfirst($propertyInfo['bath_notes']);

		$feature_note			= ucfirst($propertyInfo['feature_note']);
		$requirement_note		= ucfirst($propertyInfo['requirement_note']);
		$area_notes				= ucfirst($propertyInfo['area_notes']);
		$property_type_name		= ucfirst($propertyInfo['property_type_name']);
		$property_catering_name	= ucfirst($propertyInfo['property_catering_name']);
//		$bed_notes			= $propertyInfo['bed_notes'];
//		$bed_notes			= $propertyInfo['bed_notes'];

	}


	$strQuery 			= " AND A.property_id='".$property_id."'";
	$propLocInfo		= $propertyObj->fun_getPropertyLocInfoArr($property_id);

	if (count($propLocInfo) > 0){
		$propLoc = "";
		if($propLocInfo['location_name'] !=""){
			$propLoc .= ucwords($propLocInfo['location_name']).", ";
		}
		if($propLocInfo['region_pname'] !=""){
			$propLoc .= ucwords($propLocInfo['region_pname']).", ";
		}
		if($propLocInfo['region_name'] !=""){
			$propLoc .= ucwords($propLocInfo['region_name']).", ";
		}
		if($propLocInfo['area_name'] !=""){
			$propLoc .= ucwords($propLocInfo['area_name']).", ";
		}

		if($propLocInfo['countries_name'] !=""){
			$propLoc .= ucwords($propLocInfo['countries_name'])." ";
		}
		$propLoc .= "(Ref. No: ".$property_id.")";
	}

	$propHighlight			= "";
	if($scomfort_beds !=""){
		$propHighlight		.= $scomfort_beds." Sleeps | ";
	}

	if($total_bathrooms !=""){
		$propHighlight		.= $total_bathrooms." Bathrooms | ";
	}

	if($total_beds !=""){
		$propHighlight		.= $total_beds." Bedrooms | ";
	}

	if($property_type_name !=""){
		$propHighlight		.= ucwords($property_type_name)." | ";
	}

	if($property_catering_name !=""){
		$propHighlight		.= ucwords($property_catering_name);
	}

	$propertyPhotosInfo	= $propertyObj->fun_getPropertyMainThumb($property_id);
	if (count($propertyPhotosInfo) > 0){
//		$imgid 		= $value['photo_id'];
//		$imgcap 	= ucfirst($value['photo_caption']);
		$propertyMainImg= PROPERTY_IMAGES_LARGE.$propertyPhotosInfo[0]['photo_url'];
		$propertyMainW	= "140";
		$propertyMainH	= "100";
	}



    $community_features 		= "mytest, mytest";
    $home_features 				= "mytest, mytest";
    $views 						= "mytest, mytest";
    $heating 					= "mytest, mytest";
    $images[0]["image"]  		= "2_600x450.jpg";
    $images[0]["image_width"]  	= "352";
    $images[0]["image_height"]  = "264";
	$info["title"] 				= "mytest, mytest";
	$info["price"] 				= "mytest, mytest";
	$info["description"] 		= "mytest, mytest";


    if ($images[0]["image"]){
        $mainImage["file"] = "upload/".$images[0]["image"];
    }
    if ($images[0]["image_width"]){
        $mainImage["width"]  = convertPixelsToMm($images[0]["image_width"], 96);
        $mainImage["height"] = convertPixelsToMm($images[0]["image_width"], 96);
    }else{
        $size = image_getSize($mainImage["file"]);
        $mainImage["width"] = convertPixelsToMm($size[0], 96);
    }
    if ($images[0]["image_height"]){
        $mainImage["height"] = convertPixelsToMm($images[0]["image_height"], 96);
    }else{
        $size[1] = "264";
        $mainImage["height"] = convertPixelsToMm($size[1], 96);
    }

    class PDF extends FPDF
    {
        var $headerTitle  = "UniqueSleeps.com";
        var $titleSize    = 28;
        var $headerText   = "";
        var $textSize     = 8;

        var $footerText1   = "";
        var $footerSize    = 9;
        # Page header
        function Header()
        {

            // Save Current Y
            $currentY = $this->GetY();
            $this->SetY(10);
            $this->SetFont('Times','',$this->titleSize);
            $this->SetTextColor(128, 128, 128);
//            $this->Cell(0,0,$this->headerTitle,0,0,'C');
            $this->Ln(8);
            $this->SetFontSize($this->textSize);
//            $this->Cell(0,0,$this->headerText,0,0,'C');

            // Restore Y
            $this->SetY($currentY);
        }

        //Page footer
        function Footer()
        {
            //Position at 2 cm from bottom
            $this->SetY(-20);
            $this->SetTextColor(128, 128, 128);
            $this->SetFont('Times','',$this->footerSize);

//            $this->Cell(0,0,$this->footerText1,0,0,'C');
            $this->Ln(4);
        }
    }

    $titleSize   = 13;
    $locTextSize = 12;
    $contentSize = 10;
    $marginTop    = 23; //mm
    $marginBottom = 25; //mm
    $marginLeft   = 20; //mm
    $marginRight  = 20; //mm
    $pdfHeight    = 297 - $marginBottom - $marginTop;
    $pdfWidth     = 210 - $marginLeft - $marginBottom;

    # Instanciation of inherited class
    $pdf = new PDF('P', 'mm', 'A4'); # orientation = portrait, units = mm, format = A4
    $pdf->SetAutoPageBreak(TRUE, $marginBottom);
    $pdf->SetMargins($marginLeft, $marginTop, $marginRight); # left, top, right
    $pdf->SetDisplayMode('real', 'continuous'); # for pdf: real = 100% continuous = page after page
    $pdf->AliasNbPages();
    $pdf->AddPage();

    # Banner
	$pdf->Image($headerBanner, 20, $pdf->GetY()-10, 170, 16, 'jpg');
	$currentY = $pdf->GetY()+8;
	$pdf->SetY($currentY);

    # Property Title
    $pdf->Ln(3);
    $pdf->SetFont('Times','B',$titleSize);
    $pdf->MultiCell(0, 6,$property_name." : ".$property_title, 0, 'L');
    $pdf->Ln(3);

    # Property Location
    $pdf->SetFont('Times','',$locTextSize);
    $pdf->MultiCell(0, 6, $propLoc, 0, 'L');
    $pdf->Ln(3);

    # Property Highlight
    $pdf->SetFont('Times','',$locTextSize);
    $pdf->MultiCell(0, 6, $propHighlight, 0, 'L');
    $pdf->Ln(3);

    # Main Image
    if ($propertyMainImg){
        $pdf->Image($propertyMainImg, 20, $pdf->GetY(), $propertyMainW, $propertyMainH, 'jpg');
//        $pdf->Ln(5);
        $currentY = $pdf->GetY();
        $currentY = $currentY + $propertyMainH;
        $pdf->SetY($currentY);
    }

    # Property Summary
    $pdf->Ln(3);
    $pdf->SetFont('Times','B',$titleSize);
    $pdf->MultiCell(0, 6,"Property summary", 0, 'L');
    $pdf->Ln(3);
    $pdf->SetFont('Times','', 11);
    $pdf->Write(4,$property_summary);
    $pdf->Ln(3);

    # Property Accommodation and facilities
    $pdf->Ln(3);
    $pdf->SetFont('Times','B',$titleSize);
    $pdf->MultiCell(0, 6,"Accommodation and facilities", 0, 'L');
    $pdf->Ln(1);
    $pdf->SetFont('Times','B', 11);
    $pdf->MultiCell(0, 6,"Bedrooms", 0, 'L');
    $pdf->SetFont('Times','', 10);
    $pdf->Write(4,"Number of bedrooms".$total_beds);
    $pdf->Ln(4);
    $pdf->Write(4,"How many have en-suite?".$ensuite_beds);
    $pdf->Ln(4);
    $pdf->Write(4,"Property can comfortably sleep".$scomfort_beds);
    $pdf->Ln(4);
    $pdf->Write(4,"Double beds".$double_beds);
    $pdf->Ln(4);
    $pdf->Write(4,"Single beds".$single_beds);
    $pdf->Ln(4);
    $pdf->Write(4,"Sofa beds".$sofa_beds);
    $pdf->Ln(6);
    $pdf->Write(4, $bed_notes);
    $pdf->Ln(10);

    $pdf->Ln(1);
    $pdf->SetFont('Times','B', 11);
    $pdf->MultiCell(0, 6,"Bathrooms", 0, 'L');
    $pdf->SetFont('Times','', 10);
    $pdf->Write(4,"Number of bathrooms".$total_bathrooms);
    $pdf->Ln(4);
    $pdf->Write(4,"En-suite".$ensuite_baths);
    $pdf->Ln(4);
    $pdf->Write(4,"Baths".$baths);
    $pdf->Ln(4);
    $pdf->Write(4,"Toilets".$toilets);
    $pdf->Ln(6);
    $pdf->Write(4, $bath_notes);
    $pdf->Ln(10);

    $pdf->Ln(1);
    $pdf->SetFont('Times','B', 11);
    $pdf->MultiCell(0, 6,"Facilities", 0, 'L');
    $pdf->SetFont('Times','', 10);
    $pdf->Ln(4);
    $pdf->Write(4, $bath_notes);
    $pdf->Ln(6);
    $pdf->Write(4, $feature_note);
    $pdf->Ln(10);

    $pdf->Ln(1);
    $pdf->SetFont('Times','B', 11);
    $pdf->MultiCell(0, 6,"Special requirements", 0, 'L');
    $pdf->SetFont('Times','', 10);
    $pdf->Ln(4);
    $pdf->Write(4, $bath_notes);
    $pdf->Ln(6);
    $pdf->Write(4, $requirement_note);
    $pdf->Ln(10);

/*
    # Home Features
    if ($home_features != "")
    {
        $pdf->SetFont('','B');
        $pdf->Cell($pdf->GetStringWidth($labelPropertyFeatures),4,$labelPropertyFeatures,0,0,'L');
        $pdf->SetFont('','');
        $pdf->Write(4,$home_features);
        $pdf->Ln(10);
    }

    # Community Features
    if ($community_features != "")
    {
        $pdf->SetFont('','B');
        $pdf->Cell($pdf->GetStringWidth($labelCommunityFeatures),4,$labelCommunityFeatures,0,0,'L');
        $pdf->SetFont('','');
        $pdf->Write(4,$community_features);
        $pdf->Ln(10);
    }

    # Views
    if ($views != "")
    {
        $pdf->SetFont('','B');
        $pdf->Cell($pdf->GetStringWidth($labelView),4,$labelView,0,0,'L');
        $pdf->SetFont('','');
        $pdf->Write(4,$views);
        $pdf->Ln(10);
    }

    # Heating
    if ($heating != "")
    {
        $pdf->SetFont('','B');
        $pdf->Cell($pdf->GetStringWidth($labelHeating),4,$labelHeating,0,0,'L');
        $pdf->SetFont('','');
        $pdf->Write(4,$heating);
        $pdf->Ln(10);
    }
*/
    $pdf->Output();
?>