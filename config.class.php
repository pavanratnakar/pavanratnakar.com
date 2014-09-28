<?php
class Config{
    static $root_path  = '/home/pavanrat/public_html/mobile/survey/';
    static $site_path  = '/home/pavanrat/public_html/mobile/survey/';
    static $site_url  = 'http://www.pavanratnakar.com/mobile/survey';

    // static $root_path  = 'H:/WEB/WEBSITE/thetopremodelers/thetopremodelers/';
    // static $site_path  = 'H:/WEB/WEBSITE/thetopremodelers/thetopremodelers/';
    // static $site_url  = 'http://localhost/';


    /* DB CONFIG */
    static $db_server='localhost';
    static $db_username='pavanrat_pavan';
    static $db_password='28pepsy1998';
    static $db_database='pavanrat_main';

    // static $db_server='localhost';
    // static $db_username='root';
    // static $db_password='';
    // static $db_database='mobile_diary';
    /* DB CONFIG */
    
    /* TABLES */
    static $tables = array(
        'user_table'=>'survey_user',
        'category_table'=>'survey_category',
        'category_meta_table'=>'survey_category_meta',
        'product_table'=>'survey_product',
        'product_flavour'=>'product_flavour',
        'survey_details'=>'survey_details',
        'questionnaire_table' => 'survey_questionnaire'
    );
    /* TABLES */
}
?>