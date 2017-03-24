<?php
if($_SERVER["SERVER_NAME"] == "localhost"){
	// General Variable
	define("SITE_NAME", "yourdomain.com"); // Site Name 
	define("SITE_URL", "http://localhost/ivres/"); // Site URL
	define("SITE_SECURE_URL", "https://localhost/ivres/"); // Secure Site URL
	define("SITE_ADMIN_URL", SITE_URL . "adm/"); // Site Admin URL
	define("SITE_DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/ivres/"); // Site DOC ROOT

	define("SITE_INCLUDES_PATH", SITE_DOC_ROOT . "includes/");
	define("SITE_ADMIN_INCLUDES_PATH", SITE_DOC_ROOT . "adm/includes/");
	define("SITE_CLASSES_PATH", SITE_ADMIN_INCLUDES_PATH . "classes/");
	define("SITE_JS_INCLUDES_PATH", SITE_URL . "includes/js/");
	define("SITE_CSS_INCLUDES_PATH", SITE_URL . "css/");

	// Upload Path Variable
	define("SITE_UPLOAD_DIR", SITE_DOC_ROOT . "upload/");

	define("PROPERTY_IMAGES", SITE_UPLOAD_DIR . "property_images/");
	define("PROPERTY_IMAGES_LARGE", PROPERTY_IMAGES . "large/");
	define("PROPERTY_IMAGES_THUMB", PROPERTY_IMAGES . "thumbnail/");
	define("PROPERTY_IMAGES_LARGE600x450", PROPERTY_IMAGES . "large/600x450/");
	define("PROPERTY_IMAGES_LARGE480x360", PROPERTY_IMAGES . "large/480x360/");
	define("PROPERTY_IMAGES_LARGE244x183", PROPERTY_IMAGES . "large/244x183/");
	define("PROPERTY_IMAGES_THUMB168x126", PROPERTY_IMAGES . "thumbnail/168x126/");
	define("PROPERTY_IMAGES_THUMB88x66", PROPERTY_IMAGES . "thumbnail/88x66/");

	define("PROPERTY_VIDEO_DIR", SITE_UPLOAD_DIR . "property_videos/video/");
	define("PROPERTY_VIDEO_THUMB_SMALL", PROPERTY_VIDEO_DIR . "property_videos/frame_small/");
	define("PROPERTY_VIDEO_THUMB_LARGE", PROPERTY_VIDEO_DIR . "property_videos/frame_large/");

	define("EVENT_IMAGES", SITE_UPLOAD_DIR . "event_images/");
	define("EVENT_IMAGES_LARGE", EVENT_IMAGES . "large/");
	define("EVENT_IMAGES_THUMB", EVENT_IMAGES . "thumbnail/");
	define("EVENT_IMAGES_LARGE449x341", EVENT_IMAGES_LARGE . "449x341/");
	define("EVENT_IMAGES_THUMB168x127", EVENT_IMAGES_THUMB . "168x127/");

	define("TVLGUID_IMAGES", SITE_UPLOAD_DIR . "tvlguid_images/");
	define("TVLGUID_IMAGES_LARGE", TVLGUID_IMAGES . "large/");
	define("TVLGUID_IMAGES_THUMB", TVLGUID_IMAGES . "thumbnail/");
	define("TVLGUID_IMAGES_LARGE690x300", TVLGUID_IMAGES_LARGE . "690x300/");
	define("TVLGUID_IMAGES_LARGE449x341", TVLGUID_IMAGES_LARGE . "449x341/");
	define("TVLGUID_IMAGES_THUMB168x127", TVLGUID_IMAGES_THUMB . "168x127/");

	define("SITE_DOWNLOAD_DIR", SITE_DOC_ROOT . "download/");
	define("SITE_DOWNLOAD_PDF_DIR", SITE_DOWNLOAD_DIR . "pdf/");

	// Absolute Path Variable
	define("SITE_UPLOAD_PATH", SITE_URL . "upload/");
	define("SITE_IMAGES", SITE_URL . "images/");
	define("SITE_ADMIN_IMAGES", SITE_ADMIN_URL . "images/");

	define("PROPERTY_IMAGES_PATH", SITE_UPLOAD_PATH . "property_images/");
	define("PROPERTY_IMAGES_LARGE_PATH", PROPERTY_IMAGES_PATH . "large/");
	define("PROPERTY_IMAGES_THUMB_PATH", PROPERTY_IMAGES_PATH . "thumbnail/");
	define("PROPERTY_IMAGES_LARGE600x450_PATH", PROPERTY_IMAGES_LARGE_PATH . "600x450/");
	define("PROPERTY_IMAGES_LARGE480x360_PATH", PROPERTY_IMAGES_LARGE_PATH . "480x360/");
	define("PROPERTY_IMAGES_LARGE244x183_PATH", PROPERTY_IMAGES_LARGE_PATH . "244x183/");
	define("PROPERTY_IMAGES_THUMB168x126_PATH", PROPERTY_IMAGES_THUMB_PATH . "168x126/");
	define("PROPERTY_IMAGES_THUMB88x66_PATH", PROPERTY_IMAGES_THUMB_PATH . "88x66/");

	define("PROPERTY_VIDEO_THUMB_SMALL_PATH", SITE_UPLOAD_PATH . "property_videos/frame_small/");
	define("PROPERTY_VIDEO_THUMB_LARGE_PATH", SITE_UPLOAD_PATH . "property_videos/frame_large/");

	define("EVENT_IMAGES_PATH", SITE_UPLOAD_PATH . "event_images/");
	define("EVENT_IMAGES_LARGE_PATH", EVENT_IMAGES_PATH . "large/");
	define("EVENT_IMAGES_THUMB_PATH", EVENT_IMAGES_PATH . "thumbnail/");
	define("EVENT_IMAGES_LARGE449x341_PATH", EVENT_IMAGES_LARGE_PATH . "449x341/");
	define("EVENT_IMAGES_THUMB168x127_PATH", EVENT_IMAGES_THUMB_PATH . "168x127/");

	define("TVLGUID_IMAGES_PATH", SITE_UPLOAD_PATH . "tvlguid_images/");
	define("TVLGUID_IMAGES_LARGE_PATH", TVLGUID_IMAGES_PATH . "large/");
	define("TVLGUID_IMAGES_THUMB_PATH", TVLGUID_IMAGES_PATH . "thumbnail/");
	define("TVLGUID_IMAGES_LARGE690x300_PATH", TVLGUID_IMAGES_LARGE_PATH . "690x300/");
	define("TVLGUID_IMAGES_LARGE449x341_PATH", TVLGUID_IMAGES_LARGE_PATH . "449x341/");
	define("TVLGUID_IMAGES_THUMB168x127_PATH", TVLGUID_IMAGES_THUMB_PATH . "168x127/");

	define("SITE_DOWNLOAD_PATH", SITE_URL . "download/");
	define("SITE_DOWNLOAD_PDF_PATH", SITE_DOWNLOAD_PATH . "pdf/");


	define("SITE_INFO_EMAIL", "info@yourdomain.com");
	define("SITE_ADMIN_EMAIL", "admin@yourdomain.com");
	define("SITE_SUPPORT_EMAIL", "info@yourdomain.com");
	define("SITE_ENQUIRY_EMAIL", "info@yourdomain.com");
	define("SITE_MYPROPERTY_EMAIL", "info@yourdomain.com");
	define("SITE_AGENTS_EMAIL", "info@yourdomain.com");
	define("SITE_COMPLAINTS_EMAIL", "info@yourdomain.com");
	define("SITE_FEADBACK_EMAIL", "info@yourdomain.com");
	define("SITE_JOBS_EMAIL", "info@yourdomain.com");
	define("SITE_LINKS_EMAIL", "info@yourdomain.com");
	define("SITE_PARTNER_EMAIL", "info@yourdomain.com");
	define("SITE_PRESS_EMAIL", "info@yourdomain.com");
	define("SITE_TECH_EMAIL", "info@yourdomain.com");
	define("SITE_REGISTER_EMAIL", "info@yourdomain.com");

	define('MAIL_SERVER', 'webmail.yourdomain.com');
	define('MAIL_USERNAME', 'info@yourdomain.com');
	define('MAIL_PASSWORD', '');
	define('MAIL_METHOD', 'smtp');
	define('MAIL_SENDER', 'info@yourdomain.com');
	define('MAIL_SERVER_SENDER', $_SERVER['SERVER_NAME']);

} else if($_SERVER["SERVER_NAME"] == "www.yourdomain.com" || $_SERVER['SERVER_NAME']=="yourdomain.com"){
	// General Variable
	define("SITE_NAME", "yourdomain.com"); // Site Name 
	//define("SITE_NAME", $_SERVER["SERVER_NAME"]); // Site Name 
	define("SITE_URL", "http://www.yourdomain.com/"); // Site URL
	define("SITE_SECURE_URL", "https://www.yourdomain.com/"); // Secure Site URL

	define("SITE_ADMIN_URL", SITE_URL . "adm/"); // Site Admin URL
	define("SITE_DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");

	define("SITE_INCLUDES_PATH", SITE_DOC_ROOT . "includes/");
	define("SITE_ADMIN_INCLUDES_PATH", SITE_DOC_ROOT . "adm/includes/");
	define("SITE_CLASSES_PATH", SITE_ADMIN_INCLUDES_PATH . "classes/");
	define("SITE_JS_INCLUDES_PATH", SITE_URL . "includes/js/");
	define("SITE_CSS_INCLUDES_PATH", SITE_URL . "css/");

	// Upload Path Variable
	define("SITE_UPLOAD_DIR", SITE_DOC_ROOT . "upload/");

	define("PROPERTY_IMAGES", SITE_UPLOAD_DIR . "property_images/");
	define("PROPERTY_IMAGES_LARGE", PROPERTY_IMAGES . "large/");
	define("PROPERTY_IMAGES_THUMB", PROPERTY_IMAGES . "thumbnail/");
	define("PROPERTY_IMAGES_LARGE600x450", PROPERTY_IMAGES . "large/600x450/");
	define("PROPERTY_IMAGES_LARGE480x360", PROPERTY_IMAGES . "large/480x360/");
	define("PROPERTY_IMAGES_LARGE244x183", PROPERTY_IMAGES . "large/244x183/");
	define("PROPERTY_IMAGES_THUMB168x126", PROPERTY_IMAGES . "thumbnail/168x126/");
	define("PROPERTY_IMAGES_THUMB88x66", PROPERTY_IMAGES . "thumbnail/88x66/");

	define("PROPERTY_VIDEO_DIR", SITE_UPLOAD_DIR . "property_videos/video/");
	define("PROPERTY_VIDEO_THUMB_SMALL", PROPERTY_VIDEO_DIR . "property_videos/frame_small/");
	define("PROPERTY_VIDEO_THUMB_LARGE", PROPERTY_VIDEO_DIR . "property_videos/frame_large/");

	define("EVENT_IMAGES", SITE_UPLOAD_DIR . "event_images/");
	define("EVENT_IMAGES_LARGE", EVENT_IMAGES . "large/");
	define("EVENT_IMAGES_THUMB", EVENT_IMAGES . "thumbnail/");
	define("EVENT_IMAGES_LARGE449x341", EVENT_IMAGES_LARGE . "449x341/");
	define("EVENT_IMAGES_THUMB168x127", EVENT_IMAGES_THUMB . "168x127/");

	define("TVLGUID_IMAGES", SITE_UPLOAD_DIR . "tvlguid_images/");
	define("TVLGUID_IMAGES_LARGE", TVLGUID_IMAGES . "large/");
	define("TVLGUID_IMAGES_THUMB", TVLGUID_IMAGES . "thumbnail/");
	define("TVLGUID_IMAGES_LARGE690x300", TVLGUID_IMAGES_LARGE . "690x300/");
	define("TVLGUID_IMAGES_LARGE449x341", TVLGUID_IMAGES_LARGE . "449x341/");
	define("TVLGUID_IMAGES_THUMB168x127", TVLGUID_IMAGES_THUMB . "168x127/");

	define("SITE_DOWNLOAD_DIR", SITE_DOC_ROOT . "download/");
	define("SITE_DOWNLOAD_PDF_DIR", SITE_DOWNLOAD_DIR . "pdf/");

	// Absolute Path Variable
	define("SITE_UPLOAD_PATH", SITE_URL . "upload/");
	define("SITE_IMAGES", SITE_URL . "images/");
	define("SITE_ADMIN_IMAGES", SITE_ADMIN_URL . "images/");

	define("PROPERTY_IMAGES_PATH", SITE_UPLOAD_PATH . "property_images/");
	define("PROPERTY_IMAGES_LARGE_PATH", PROPERTY_IMAGES_PATH . "large/");
	define("PROPERTY_IMAGES_THUMB_PATH", PROPERTY_IMAGES_PATH . "thumbnail/");
	define("PROPERTY_IMAGES_LARGE600x450_PATH", PROPERTY_IMAGES_LARGE_PATH . "600x450/");
	define("PROPERTY_IMAGES_LARGE480x360_PATH", PROPERTY_IMAGES_LARGE_PATH . "480x360/");
	define("PROPERTY_IMAGES_LARGE244x183_PATH", PROPERTY_IMAGES_LARGE_PATH . "244x183/");
	define("PROPERTY_IMAGES_THUMB168x126_PATH", PROPERTY_IMAGES_THUMB_PATH . "168x126/");
	define("PROPERTY_IMAGES_THUMB88x66_PATH", PROPERTY_IMAGES_THUMB_PATH . "88x66/");

	define("PROPERTY_VIDEO_THUMB_SMALL_PATH", SITE_UPLOAD_PATH . "property_videos/frame_small/");
	define("PROPERTY_VIDEO_THUMB_LARGE_PATH", SITE_UPLOAD_PATH . "property_videos/frame_large/");

	define("EVENT_IMAGES_PATH", SITE_UPLOAD_PATH . "event_images/");
	define("EVENT_IMAGES_LARGE_PATH", EVENT_IMAGES_PATH . "large/");
	define("EVENT_IMAGES_THUMB_PATH", EVENT_IMAGES_PATH . "thumbnail/");
	define("EVENT_IMAGES_LARGE449x341_PATH", EVENT_IMAGES_LARGE_PATH . "449x341/");
	define("EVENT_IMAGES_THUMB168x127_PATH", EVENT_IMAGES_THUMB_PATH . "168x127/");

	define("TVLGUID_IMAGES_PATH", SITE_UPLOAD_PATH . "tvlguid_images/");
	define("TVLGUID_IMAGES_LARGE_PATH", TVLGUID_IMAGES_PATH . "large/");
	define("TVLGUID_IMAGES_THUMB_PATH", TVLGUID_IMAGES_PATH . "thumbnail/");
	define("TVLGUID_IMAGES_LARGE690x300_PATH", TVLGUID_IMAGES_LARGE_PATH . "690x300/");
	define("TVLGUID_IMAGES_LARGE449x341_PATH", TVLGUID_IMAGES_LARGE_PATH . "449x341/");
	define("TVLGUID_IMAGES_THUMB168x127_PATH", TVLGUID_IMAGES_THUMB_PATH . "168x127/");

	define("SITE_DOWNLOAD_PATH", SITE_URL . "download/");
	define("SITE_DOWNLOAD_PDF_PATH", SITE_DOWNLOAD_PATH . "pdf/");

	define("SITE_INFO_EMAIL", "info@yourdomain.com");
	define("SITE_ADMIN_EMAIL", "admin@yourdomain.com");
	define("SITE_SUPPORT_EMAIL", "info@yourdomain.com");
	define("SITE_ENQUIRY_EMAIL", "info@yourdomain.com");
	define("SITE_MYPROPERTY_EMAIL", "info@yourdomain.com");
	define("SITE_AGENTS_EMAIL", "info@yourdomain.com");
	define("SITE_COMPLAINTS_EMAIL", "info@yourdomain.com");
	define("SITE_FEADBACK_EMAIL", "info@yourdomain.com");
	define("SITE_JOBS_EMAIL", "info@yourdomain.com");
	define("SITE_LINKS_EMAIL", "info@yourdomain.com");
	define("SITE_PARTNER_EMAIL", "info@yourdomain.com");
	define("SITE_PRESS_EMAIL", "info@yourdomain.com");
	define("SITE_TECH_EMAIL", "info@yourdomain.com");
	define("SITE_REGISTER_EMAIL", "info@yourdomain.com");

	define('MAIL_SERVER', 'webmail.yourdomain.com');
	define('MAIL_USERNAME', 'info@yourdomain.com');
	define('MAIL_PASSWORD', '');
	define('MAIL_METHOD', 'smtp');
	define('MAIL_SENDER', 'info@yourdomain.com');
	define('MAIL_SERVER_SENDER', $_SERVER['SERVER_NAME']);
} else {
	// General Variable
	define("SITE_NAME", "www.yourdomain.com"); // Site Name 
	define("SITE_URL", "http://".$_SERVER['SERVER_NAME']."/projects/ivres/1/"); // Site URL
	define("SITE_SECURE_URL", "https://".$_SERVER['SERVER_NAME']."/projects/ivres/1/"); // Secure Site URL

	define("SITE_ADMIN_URL", SITE_URL . "adm/"); // Site Admin URL
	define("SITE_DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/projects/ivres/1/"); // Site DOC ROOT
	
	define("SITE_INCLUDES_PATH", SITE_DOC_ROOT . "includes/");
	define("SITE_ADMIN_INCLUDES_PATH", SITE_DOC_ROOT . "adm/includes/");
	define("SITE_CLASSES_PATH", SITE_ADMIN_INCLUDES_PATH . "classes/");
	define("SITE_JS_INCLUDES_PATH", SITE_URL . "includes/js/");
	define("SITE_CSS_INCLUDES_PATH", SITE_URL . "css/");

	// Upload Path Variable
	define("SITE_UPLOAD_DIR", SITE_DOC_ROOT . "upload/");

	define("PROPERTY_IMAGES", SITE_UPLOAD_DIR . "property_images/");
	define("PROPERTY_IMAGES_LARGE", PROPERTY_IMAGES . "large/");
	define("PROPERTY_IMAGES_THUMB", PROPERTY_IMAGES . "thumbnail/");
	define("PROPERTY_IMAGES_LARGE600x450", PROPERTY_IMAGES . "large/600x450/");
	define("PROPERTY_IMAGES_LARGE480x360", PROPERTY_IMAGES . "large/480x360/");
	define("PROPERTY_IMAGES_LARGE244x183", PROPERTY_IMAGES . "large/244x183/");
	define("PROPERTY_IMAGES_THUMB168x126", PROPERTY_IMAGES . "thumbnail/168x126/");
	define("PROPERTY_IMAGES_THUMB88x66", PROPERTY_IMAGES . "thumbnail/88x66/");

	define("PROPERTY_VIDEO_DIR", SITE_UPLOAD_DIR . "property_videos/video/");
	define("PROPERTY_VIDEO_THUMB_SMALL", PROPERTY_VIDEO_DIR . "property_videos/frame_small/");
	define("PROPERTY_VIDEO_THUMB_LARGE", PROPERTY_VIDEO_DIR . "property_videos/frame_large/");

	define("EVENT_IMAGES", SITE_UPLOAD_DIR . "event_images/");
	define("EVENT_IMAGES_LARGE", EVENT_IMAGES . "large/");
	define("EVENT_IMAGES_THUMB", EVENT_IMAGES . "thumbnail/");
	define("EVENT_IMAGES_LARGE449x341", EVENT_IMAGES_LARGE . "449x341/");
	define("EVENT_IMAGES_THUMB168x127", EVENT_IMAGES_THUMB . "168x127/");

	define("TVLGUID_IMAGES", SITE_UPLOAD_DIR . "tvlguid_images/");
	define("TVLGUID_IMAGES_LARGE", TVLGUID_IMAGES . "large/");
	define("TVLGUID_IMAGES_THUMB", TVLGUID_IMAGES . "thumbnail/");
	define("TVLGUID_IMAGES_LARGE690x300", TVLGUID_IMAGES_LARGE . "690x300/");
	define("TVLGUID_IMAGES_LARGE449x341", TVLGUID_IMAGES_LARGE . "449x341/");
	define("TVLGUID_IMAGES_THUMB168x127", TVLGUID_IMAGES_THUMB . "168x127/");

	define("SITE_DOWNLOAD_DIR", SITE_DOC_ROOT . "download/");
	define("SITE_DOWNLOAD_PDF_DIR", SITE_DOWNLOAD_DIR . "pdf/");

	// Absolute Path Variable
	define("SITE_UPLOAD_PATH", SITE_URL . "upload/");
	define("SITE_IMAGES", SITE_URL . "images/");
	define("SITE_ADMIN_IMAGES", SITE_ADMIN_URL . "images/");

	define("PROPERTY_IMAGES_PATH", SITE_UPLOAD_PATH . "property_images/");
	define("PROPERTY_IMAGES_LARGE_PATH", PROPERTY_IMAGES_PATH . "large/");
	define("PROPERTY_IMAGES_THUMB_PATH", PROPERTY_IMAGES_PATH . "thumbnail/");
	define("PROPERTY_IMAGES_LARGE600x450_PATH", PROPERTY_IMAGES_LARGE_PATH . "600x450/");
	define("PROPERTY_IMAGES_LARGE480x360_PATH", PROPERTY_IMAGES_LARGE_PATH . "480x360/");
	define("PROPERTY_IMAGES_LARGE244x183_PATH", PROPERTY_IMAGES_LARGE_PATH . "244x183/");
	define("PROPERTY_IMAGES_THUMB168x126_PATH", PROPERTY_IMAGES_THUMB_PATH . "168x126/");
	define("PROPERTY_IMAGES_THUMB88x66_PATH", PROPERTY_IMAGES_THUMB_PATH . "88x66/");

	define("PROPERTY_VIDEO_THUMB_SMALL_PATH", SITE_UPLOAD_PATH . "property_videos/frame_small/");
	define("PROPERTY_VIDEO_THUMB_LARGE_PATH", SITE_UPLOAD_PATH . "property_videos/frame_large/");

	define("EVENT_IMAGES_PATH", SITE_UPLOAD_PATH . "event_images/");
	define("EVENT_IMAGES_LARGE_PATH", EVENT_IMAGES_PATH . "large/");
	define("EVENT_IMAGES_THUMB_PATH", EVENT_IMAGES_PATH . "thumbnail/");
	define("EVENT_IMAGES_LARGE449x341_PATH", EVENT_IMAGES_LARGE_PATH . "449x341/");
	define("EVENT_IMAGES_THUMB168x127_PATH", EVENT_IMAGES_THUMB_PATH . "168x127/");

	define("TVLGUID_IMAGES_PATH", SITE_UPLOAD_PATH . "tvlguid_images/");
	define("TVLGUID_IMAGES_LARGE_PATH", TVLGUID_IMAGES_PATH . "large/");
	define("TVLGUID_IMAGES_THUMB_PATH", TVLGUID_IMAGES_PATH . "thumbnail/");
	define("TVLGUID_IMAGES_LARGE690x300_PATH", TVLGUID_IMAGES_LARGE_PATH . "690x300/");
	define("TVLGUID_IMAGES_LARGE449x341_PATH", TVLGUID_IMAGES_LARGE_PATH . "449x341/");
	define("TVLGUID_IMAGES_THUMB168x127_PATH", TVLGUID_IMAGES_THUMB_PATH . "168x127/");

	define("SITE_DOWNLOAD_PATH", SITE_URL . "download/");
	define("SITE_DOWNLOAD_PDF_PATH", SITE_DOWNLOAD_PATH . "pdf/");

	define("SITE_INFO_EMAIL", "info@yourdomain.com");
	define("SITE_ADMIN_EMAIL", "admin@yourdomain.com");
	define("SITE_SUPPORT_EMAIL", "info@yourdomain.com");
	define("SITE_ENQUIRY_EMAIL", "info@yourdomain.com");
	define("SITE_MYPROPERTY_EMAIL", "info@yourdomain.com");
	define("SITE_AGENTS_EMAIL", "info@yourdomain.com");
	define("SITE_COMPLAINTS_EMAIL", "info@yourdomain.com");
	define("SITE_FEADBACK_EMAIL", "info@yourdomain.com");
	define("SITE_JOBS_EMAIL", "info@yourdomain.com");
	define("SITE_LINKS_EMAIL", "info@yourdomain.com");
	define("SITE_PARTNER_EMAIL", "info@yourdomain.com");
	define("SITE_PRESS_EMAIL", "info@yourdomain.com");
	define("SITE_TECH_EMAIL", "info@yourdomain.com");
	define("SITE_REGISTER_EMAIL", "info@yourdomain.com");

	define('MAIL_SERVER', 'webmail.yourdomain.com');
	define('MAIL_USERNAME', 'info@yourdomain.com');
	define('MAIL_PASSWORD', '');
	define('MAIL_METHOD', 'smtp');
	define('MAIL_SENDER', 'info@yourdomain.com');
	define('MAIL_SERVER_SENDER', $_SERVER['SERVER_NAME']);
}

define('DEFAULT_CURRENCY', '1');
define('SMS_USERNAME', 'IDNS');
define('SMS_PASSWORD', 'testtest');
define('SMS_API', '3176086');

define("GLOBAL_RECORDS_PER_PAGE", 10);
//define("EMAIL_ID_REG_EXP_PATTERN", "/^([a-zA-Z][a-zA-Z0-9\_\-\.]*\@[a-zA-Z0-9\-]*\.[a-zA-Z]{2,4})?$/i");

define("EMAIL_ID_REG_EXP_PATTERN", "/^[^\W][a-zA-Z0-9\_\-\.]+(\.[a-zA-Z0-9\_\-\.]+)*\@[a-zA-Z0-9\_\-]+(\.[a-zA-Z0-9\_\-]+)*\.[a-zA-Z]{2,4}$/");

//define("EMAIL_ID_REG_EXP_PATTERN", "/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD");
?>