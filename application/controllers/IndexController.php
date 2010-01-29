<?php

class IndexController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        /**
         * Use Case 1
         * 
         * Search for the term "Michael Jackson"
         * and display all results as an array
         */
        
        $uc1 = new Zend_Service_Itunes_Search();
        $uc1->setTerms('michael jackson');
        $uc1->setResultFormat(Zend_Service_ItunesAbstract::RESULT_ARRAY);
        
        // query service and return new Zend_Service_Itunes_ResultSet object
        $results = $uc1->query();
        
        foreach ($results as $result) {
            // dumps the content of the actual result
            var_dump($result);
        }
    }
}