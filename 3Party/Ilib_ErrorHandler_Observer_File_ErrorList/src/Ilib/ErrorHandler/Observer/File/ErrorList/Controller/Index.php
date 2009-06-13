<?php

class Intraface_Tools_Controller_ErrorList extends k_Controller
{
    public $map = array(
        'rss' => 'Intraface_Tools_Controller_ErrorList_RSS',
        'all' => 'Intraface_Tools_Controller_ErrorList_All',
        'unique' => 'Intraface_Tools_Controller_ErrorList_Unique'
    );

    
    public function GET()
    {
        return 'Intentionally left blank';
    }
}