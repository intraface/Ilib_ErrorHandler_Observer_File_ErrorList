<?php

class Ilib_ErrorHandler_Observer_File_ErrorList_Controller_View_Unique extends Ilib_ErrorHandler_Observer_File_ErrorList_Controller_View
{
    
    public function getErrorList() 
    {
        return $this->registry->get('errorlist')->getUnique();
    }
    
}