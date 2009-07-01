<?php

class Ilib_ErrorHandler_Observer_File_ErrorList_Controller_Index extends k_Controller
{
    public $map = array(
        'rss' => 'Ilib_ErrorHandler_Observer_File_ErrorList_Controller_View_RSS',
        'all' => 'Ilib_ErrorHandler_Observer_File_ErrorList_Controller_View_All',
        'unique' => 'Ilib_ErrorHandler_Observer_File_ErrorList_Controller_View_Unique'
    );

    
    public function GET()
    {
        return 'Intentionally left blank';
    }
}