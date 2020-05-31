<?php

namespace Inside4\TextsTranslate;

Class TextsTranslate {

    var $LanguagesTable = 'lang_names';
    var $VocabularyTable = 'lang_vocabulary';
    var $activeLanguage;
    var $defaultLanguage = '';
    var $LoadedVocabulary;

    // Dependencies
    var $db;

    //i--- TextsTranslate init and define system language ; inside_text_transalate ; torrison ; 01.08.2018 ; 1 ---/
    public function init(){

        if ($this->defaultLanguage == '') $this->defaultLanguage = $GLOBALS['inside4']['translate']['default_lang'];
        $this->activeLanguage = $this->defaultLanguage;

        foreach ($this->getLanguages() as $lang) {
            if ($GLOBALS['inside4']['translate']['uri_prefix_value'] == $lang['lang_alias']) $this->activeLanguage = $lang['lang_alias'];
        }

        $GLOBALS['inside4']['translate']['active_language'] = $this->activeLanguage;

        // Load Vocabulary
        $query = "SELECT * FROM ".$this->VocabularyTable." WHERE vocabulary_lang = ".$this->db->quote($this->activeLanguage);
        $data = $this->db->sql_get_data($query);

        // Prepare "Fast" array
        $res = Array();
        foreach ($data as $row) $res[$row['vocabulary_alias']] = $row['vocabulary_name'];

        $this->LoadedVocabulary = $res;

        //i--- GLOBALS Language Checks ; inside_text_transalate ; torrison ; 01.05.2020 ; 1a ---/
        if ($GLOBALS['inside4']['translate']['uri_prefix_value'] == '') $GLOBALS['Commons']['lang'] = $this->defaultLanguage;
        $GLOBALS['Commons']['lang'] = str_replace('/', '', $GLOBALS['inside4']['translate']['uri_prefix_value']);

    }

    //i--- Get Translated Words by alias ; inside_text_transalate ; torrison ; 01.08.2018 ; 2 ---/
    public function get($alias) {
        if (!isset($this->LoadedVocabulary[$alias])) $this->LoadedVocabulary[$alias] = $alias;
        return $this->LoadedVocabulary[$alias];
    }

    //i--- Get Languages List ; inside_text_transalate ; torrison ; 01.08.2018 ; 3 ---/
    public function getLanguages() {

        $query = "SELECT * FROM ".$this->LanguagesTable." WHERE off = 0 ORDER by priority";
        $data = $this->db->sql_get_data($query);
        return $data;
    }

    //i--- Get All Language Array for Apps Cache List ; inside_text_transalate ; torrison ; 07.08.2018 ; 4 ---/
    public function get_all_vocabulary_arr($lang_alias) {
        $res = $this->db->sql_get_data("SELECT *
									FROM ".$this->VocabularyTable."
									WHERE vocabulary_lang = ".$this->db->quote($lang_alias)."
									");
        return $res;
    }
}