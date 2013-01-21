<?php
class Config
{
    static $root_path  = '/home/pavanrat/public_html/';
    static $admin_path = '/home/pavanrat/public_html/projects/herve/admin/';
    static $site_path  = '/home/pavanrat/public_html/projects/herve/';
    static $site_url  = 'http://www.pavanratnakar.com/projects/herve/';

    /* DB CONFIG */
    static $db_server='localhost';
    static $db_username='pavanrat_pavan';
    static $db_password='28pepsy1998';
    static $db_database='pavanrat_main';
    /* DB CONFIG */
    
    /* TABLES */
    static $tables = array(
        'category_table'=>'rene_category',
        'section_table'=>'rene_section',
        'categorySection_table' => 'rene_categorysection_mapping',
        'question_table' => 'rene_questions',
        'question_category' => 'rene_question_category',
        'sectionQuestion_table' => 'rene_sectionquestion_mapping',
        'answer_table' => 'rene_answers',
        'questionAnswer_table' => 'rene_questionanwer_mapping',
        'article_table' => 'rene_article'
    );
    /* TABLES */
}
?>