<?php

namespace Inside4\TextsTranslate;

Class TextsTranslate {

    var $LanguagesTable = 'lang_names';
    var $VocabularyTable = 'lang_vocabulary';
    var $activeLanguage;
    var $defaultLanguage = 'en';
    var $LoadedVocabulary;

    // Dependencies
    var $db;

    public function init(){

        $this->activeLanguage = $this->defaultLanguage;

        foreach ($this->getLanguages() as $lang) {
            if ($GLOBALS['inside4']['translate']['uri_prefix_value'] == $lang['lang_alias']) $this->activeLanguage = $lang['lang_alias'];
        }

        // Load Vocabulary
        $query = "SELECT * FROM ".$this->VocabularyTable." WHERE vocabulary_lang = ".$this->db->quote($this->activeLanguage);
        $data = $this->db->sql_get_data($query);

        // Prepare "Fast" array
        $res = Array();
        foreach ($data as $row) $res[$row['vocabulary_alias']] = $row['vocabulary_name'];

        $this->LoadedVocabulary = $res;

    }

    // Get Translated Words by alias
    public function get($alias) {
        if (!isset($this->LoadedVocabulary[$alias])) $this->LoadedVocabulary[$alias] = $alias;
        return $this->LoadedVocabulary[$alias];
    }

    public function getLanguages() {

        $query = "SELECT * FROM ".$this->LanguagesTable." WHERE off = 0 ORDER by priority";
        $data = $this->db->sql_get_data($query);
        return $data;
    }

}