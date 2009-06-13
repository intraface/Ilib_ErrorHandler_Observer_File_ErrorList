<?php

class Ilib_ErrorHandler_Observer_File_ErrorList_Controller_View_All extends Ilib_ErrorHandler_Observer_File_ErrorList_Controller_View
{
    
    public function getErrorList() 
    {
        return $this->registry->get('errorlist')->getAll();
    }
    
}