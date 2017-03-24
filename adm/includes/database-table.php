<?php
// Property specific tables
define("TABLE_PROPERTY", "vr_property"); // updated 19 Mar, 2008
define("TABLE_PROPERTY_TYPE", "vr_property_type");
define("TABLE_PROPERTY_CATERING", "vr_property_catering");
define("TABLE_PROPERTY_AMMENITIES", "vr_property_ammenities");
define("TABLE_PROPERTY_FEATURES", "vr_property_features");
define("TABLE_PROPERTY_SPECIAL_REQUIREMENTS", "vr_property_srequirements");
define("TABLE_PROPERTY_ACCOMMODATION", "vr_property_accommodation");
define("TABLE_PROPERTY_BEDROOM", "vr_property_bedroom");
define("TABLE_PROPERTY_BATHROOM", "vr_property_bathroom");
define("TABLE_PROPERTY_LANDMARKS", "vr_property_landmarks");
define("TABLE_PROPERTY_AVAILABILITY", "vr_property_availability");
define("TABLE_PROPERTY_STATUS", "vr_property_status");
define("TABLE_PROPERTY_SPECIAL_DEALS", "vr_property_special_deals"); // updated 15 Apr, 2008

// Property relation specific tables
define("TABLE_PROPERTY_OWNER_RELATIONS", "vr_property_owner_relations");  // updated 19 Mar, 2008
define("TABLE_PROPERTY_BACKLINK_RELATIONS", "vr_property_backlink_relations");  // updated 10 Apr, 2014
define("TABLE_PROPERTY_BEDROOM_RELATIONS", "vr_property_bedroom_relations"); // updated 20 Mar, 2008
define("TABLE_PROPERTY_BATHROOM_RELATIONS", "vr_property_bathroom_relations"); // updated 20 Mar, 2008
define("TABLE_PROPERTY_FEATURES_RELATIONS", "vr_property_features_relations");  // updated 20 Mar, 2008
define("TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS", "vr_property_srequirements_relations");  // updated 19 Mar, 2008
define("TABLE_PROPERTY_SELLING_POINTS_RELATIONS", "vr_property_selling_points_relations"); // updated 20 Mar, 2008
define("TABLE_PROPERTY_TAGS", "vr_property_tags"); // updated 22 Dec, 2009
define("TABLE_PROPERTY_PHOTO_ALL", "vr_property_photo_all"); // updated 20 Mar, 2008
define("TABLE_PROPERTY_LOCATION_GUIDES", "vr_property_location_guides"); // updated 20 Mar, 2008
define("TABLE_PROPERTY_AREA_NOTES", "vr_property_area_notes"); // updated 20 Mar, 2008
define("TABLE_PROPERTY_LANDMARK_RELATIONS", "vr_property_landmark_relations"); // updated 20 Mar, 2008
define("TABLE_PROPERTY_EXTRA_LANDMARKS", "vr_property_extra_landmarks"); // updated 20 Mar, 2008
define("TABLE_PROPERTY_CHECKLIST_SETTINGS", "vr_property_checklist_settings"); // updated 20 Mar, 2008
define("TABLE_PROPERTY_SPECIAL_DEAL_STATUS", "vr_property_special_deal_status"); // updated 15 Apr, 2008
define("TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS", "vr_property_special_deals_relations"); // updated 15 Apr, 2008

define("TABLE_PROPERTY_PRICE_NOTES", "vr_property_price_notes");
define("TABLE_PROPERTY_AVAILABILITY_RELATIONS", "vr_property_availability_relations");
define("TABLE_PROPERTY_CONTACT_LANGUAGES", "vr_property_contact_languages");
define("TABLE_PROPERTY_CONTACT_NUMBERS", "vr_property_contact_numbers");
define("TABLE_PROPERTY_VIDEO_ALL", "vr_property_video_all");
define("TABLE_PROPERTY_PRICES", "vr_property_prices");
define("TABLE_PROPERTY_CONTACTS", "vr_property_contacts");
define("TABLE_PROPERTY_REVIEWS_STATUS", "vr_property_reviews_status"); // updated 13 May, 2008
define("TABLE_PROPERTY_REVIEWS_RELATIONS", "vr_property_review_relations"); // updated 13 May, 2008
define("TABLE_PROPERTY_REVIEWVOTES_RELATIONS", "vr_property_reviewvotes_relations"); // updated 13 May, 2008
define("TABLE_PROPERTY_OWNERWEBSITE_RELATIONS", "vr_property_ownerwebsite_relations"); // updated 15 May, 2008
define("TABLE_PROPERTY_DECLINE_REASONS", "vr_property_decline_reasons"); // updated 22 Jun, 2008
define("TABLE_PROPERTY_ADMIN_REVIEWS", "vr_property_admin_reviews"); // updated 22 Jun, 2008
define("TABLE_PROPERTY_DECLINE_INFO", "vr_property_decline_info"); // updated 22 Jun, 2008

define("TABLE_PROPERTY_AVAILABILITY_RELATIONS_TMP", "vr_property_availability_relations_tmp"); // may be dropped in future
define("TABLE_PROPERTY_UNITS", "vr_property_units"); // may be dropped in future
define("TABLE_PROPERTY_PHOTOS_TEMP", "vr_property_photos_temp"); // may be dropped in future
define("TABLE_PROPERTY_HOT_RELATIONS", "vr_property_hot_relations");

// User enquiry tables
define("TABLE_ENQUIRIES", "vr_enquiries");
define("TABLE_PROPERTY_ENQUIRIES_RELATIONS", "vr_property_enquiry_relations");
define("TABLE_USER_ENQUIRIES_RELATIONS", "vr_user_enquiry_relations");

//For property visit
define("TABLE_PROPERTY_VISIT_RELATIONS", "vr_property_visit_relations"); //Added on 27 Jun, 2013

// User specific tables
define("TABLE_USERS", "vr_users");
define("TABLE_USERS_NEWSLETTER", "vr_tbl_users_newsletter");
define("TABLE_USER_CONTACT_LANGUAGES", "vr_user_contact_languages");
define("TABLE_USER_CONTACT_NUMBERS", "vr_user_contact_numbers");
define("TABLE_USER_SMS_NUMBERS", "vr_user_sms_numbers");
define("TABLE_USER_MESSAGES", "vr_user_messages");
define("TABLE_USER_MESSAGE_TYPE", "vr_user_message_type");
define("TABLE_USER_CART", "vr_user_basket");
define("TABLE_USER_CHECKLIST_SETTINGS", "vr_user_checklist_settings");
define("TABLE_USER_HEARABOUTUS", "vr_user_hearaboutus");
define("TABLE_USER_SETTINGS", "vr_user_settings");
define("TABLE_USER_SETTING_RELATIONS", "vr_user_setting_relations");
define("TABLE_USER_NEWSLETTER", "vr_user_newsletter");
define("TABLE_USER_FAVOURITE_PROPERTIES", "vr_user_favourite_properties");  // updated 19 May, 2008
define("TABLE_USER_CURRENCY_SETTINGS", "vr_user_currency_settings");  // updated 5 Jun, 2008
define("TABLE_USER_CHECKLIST_SETTINGS_TMP", "vr_user_checklist_settings_tmp");
define("TABLE_USER_PROMOTION_CODES", "vr_user_promotion_codes");
define("TABLE_USER_BOOKING_RELATIONS", "vr_user_booking_relations");

// Site product specific tables
define("TABLE_PRODUCTS", "vr_products");
define("TABLE_PRODUCTS_PRICE_HISTORY", "vr_products_price_history");
//define("TABLE_PRODUCTS_ATTRIBUTES", "vr_products_attributes");
//define("TABLE_PRODUCTS_OPTIONS", "vr_products_options");
//define("TABLE_PRODUCTS_OPTIONS_VALUES", "vr_products_options_values");
//define("TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS", "vr_products_options_values_to_products_options");
define("TABLE_PAYMENT_STATUS", "vr_payment_status");

// Site order specific tables
define("TABLE_ORDERS", "vr_orders");
define("TABLE_ORDERS_PRODUCTS", "vr_orders_products");
define("TABLE_ORDERS_PRODUCTS_PROPERTIES", "vr_orders_products_properties");
//define("TABLE_ORDERS_PRODUCTS_ATTRIBUTES", "vr_orders_products_attributes");
define("TABLE_ORDERS_STATUS", "vr_orders_status");
define("TABLE_ORDERS_STATUS_HISTORY", "vr_orders_status_history");

// Event Specific tables
define("TABLE_EVENTS_CATEGORIES", "vr_events_categories"); //Updated on 26 Aug, 2008
define("TABLE_EVENTS", "vr_events"); //Updated on 26 Aug, 2008
define("TABLE_EVENTS_TMP", "vr_events_tmp"); //Updated on 26 Aug, 2008
define("TABLE_EVENTS_STATUS", "vr_events_status"); //Updated on 31 Aug, 2008

// Travel Guide Specific tables
define("TABLE_TRAVEL_GUIDES_CATEGORIES", "vr_travel_guides_categories"); //Updated on 13 Sep, 2008
define("TABLE_TRAVEL_GUIDES", "vr_travel_guides"); //Updated on 13 Sep, 2008
define("TABLE_TRAVEL_GUIDES_TMP", "vr_travel_guides_tmp"); //Updated on 13 Sep, 2008
define("TABLE_TRAVEL_GUIDES_PHOTOS", "vr_travel_guides_photo_all"); //Updated on 13 Sep, 2008
define("TABLE_TRAVEL_GUIDES_STATUS", "vr_travel_guides_status"); //Updated on 13 Sep, 2008

// Address / Location specific tables
define("TABLE_COUNTRIES", "vr_tbl_countries");
define("TABLE_AREA", "vr_tbl_area");
define("TABLE_REGION", "vr_tbl_region");
define("TABLE_LOCATION", "vr_tbl_location");

// PhpMyVisite tables
define("TABLE_PMV_A_CONFIG", "vr_phpmv_a_config");
define("TABLE_PMV_A_FILE", "vr_phpmv_a_file");
define("TABLE_PMV_A_KEYWORD", "vr_phpmv_a_keyword");
define("TABLE_PMV_A_NEWSLETTER", "vr_phpmv_a_newsletter");
define("TABLE_PMV_A_PAGE", "vr_phpmv_a_page");
define("TABLE_PMV_A_PARTNER_NAME", "vr_phpmv_a_partner_name");
define("TABLE_PMV_A_PARTNER_URL", "vr_phpmv_a_partner_url");
define("TABLE_PMV_A_PROVIDER", "vr_phpmv_a_provider");
define("TABLE_PMV_A_RESOLUTION", "vr_phpmv_a_resolution");
define("TABLE_PMV_A_SEARCH_ENGINE", "vr_phpmv_a_search_engine");
define("TABLE_PMV_A_SITE", "vr_phpmv_a_site");
define("TABLE_PMV_A_VARS_NAME", "vr_phpmv_a_vars_name");
define("TABLE_PMV_A_VARS_VALUE", "vr_phpmv_a_vars_value");
define("TABLE_PMV_ARCHIVES", "vr_phpmv_archives");
define("TABLE_PMV_CATEGORY", "vr_phpmv_category");
define("TABLE_PMV_GROUPS", "vr_phpmv_groups");
define("TABLE_PMV_IP_IGNORE", "vr_phpmv_ip_ignore");
define("TABLE_PMV_LINK_VP", "vr_phpmv_link_vp");
define("TABLE_PMV_LINK_VPV", "vr_phpmv_link_vpv");	
define("TABLE_PMV_NEWSLETTER", "vr_phpmv_newsletter");
define("TABLE_PMV_PAGE", "vr_phpmv_page");
define("TABLE_PMV_PAGE_MD5URL", "vr_phpmv_page_md5url");
define("TABLE_PMV_PAGE_URL", "vr_phpmv_page_url");
define("TABLE_PMV_PDF_CONFIG", "vr_phpmv_pdf_config");
define("TABLE_PMV_PDF_SITE_USER", "vr_phpmv_pdf_site_user");
define("TABLE_PMV_PLUGIN_VERSION", "vr_phpmv_plugin_version");
define("TABLE_PMV_QUERY_LOG", "vr_phpmv_query_log");
define("TABLE_PMV_SITE", "vr_phpmv_site");
define("TABLE_PMV_SITE_PARTNER", "vr_phpmv_site_partner");
define("TABLE_PMV_SITE_PARTNER_URL", "vr_phpmv_site_partner_url");
define("TABLE_PMV_SITE_URL", "vr_phpmv_site_url");
define("TABLE_PMV_USERS", "vr_phpmv_users");
define("TABLE_PMV_USERS_LINK_GROUPS", "vr_phpmv_users_link_groups");
define("TABLE_PMV_VARS", "vr_phpmv_vars");
define("TABLE_PMV_VERSION", "vr_phpmv_version");
define("TABLE_PMV_VISIT", "vr_phpmv_visit");


// resources Specific tables
define("TABLE_RESOURCES_CATEGORIES", "vr_resources_categories"); //Updated on 30 Dec, 2008
define("TABLE_RESOURCES", "vr_resources"); //Updated on 30 Dec, 2008
define("TABLE_RESOURCES_TMP", "vr_resources_tmp"); //Updated on 30 Dec, 2008
define("TABLE_RESOURCES_STATUS", "vr_resources_status"); //Updated on 30 Dec, 2008
define("TABLE_USER_RESOURCES_RELATIONS", "vr_user_resource_relations"); //Updated on 30 Dec, 2008

// Testimonial Specific tables
define("TABLE_TESTIMONIALS", "vr_testimonials"); //Updated on 30 Dec, 2008
define("TABLE_TESTIMONIALS_STATUS", "vr_testimonials_status"); //Updated on 30 Dec, 2008
define("TABLE_USER_TESTIMONIAL_RELATIONS", "vr_user_testimonial_relations"); //Updated on 30 Dec, 2008

// Testimonial Specific tables
define("TABLE_PROMOS", "vr_promos"); //Updated on 9 Mar, 2009
define("TABLE_PROMOS_CATEGORY", "vr_promos_category"); //Updated on 9 Mar, 2009

// Other support tables
define("TABLE_CURRENCIES", "vr_tbl_currencies");
define("TABLE_CONTACT_NO_TYPE", "vr_tbl_contact_no_type");
define("TABLE_HOLIDAY", "vr_tbl_holiday");
define("TABLE_HOLIDAY_MAKER", "vr_tbl_holiday_maker");
define("TABLE_LANGUAGES", "vr_tbl_languages");

//CMS
define("TABLE_CMS", "vr_page");
define("TABLE_HOME_BANNER", "vr_home_banner");
define("TABLE_BANNER", "vr_banner");
define("TABLE_NEWSLETTER", "vr_newletters");
define("TABLE_TAGS", "vr_tags");

//Booking
define("TABLE_PROPERTY_BOOKINGS", "vr_property_bookings");
define("TABLE_SITE_VARIABLE", "vr_site_variable");

define("TABLE_USER_SESSION", "vr_user_session");
//translation
define("TABLE_LANGUAGE", "vr_languages");
define("TABLE_APP_SEO", "vr_app_seo");
define("TABLE_SECTION", "vr_section");
define("TABLE_TRANSLATION", "vr_translation");

//Packages
define("TABLE_PACKAGES", "vr_packages");
define("TABLE_PACKAGE_OWNER_RELATIONS", "vr_package_owner_relations");

?>