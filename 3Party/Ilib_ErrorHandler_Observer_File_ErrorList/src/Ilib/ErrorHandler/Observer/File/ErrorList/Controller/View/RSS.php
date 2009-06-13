<?php
class Ilib_ErrorHandler_Observer_File_ErrorList_Controller_View_RSS extends k_Controller
{
    function GET()
    {
        $data['items'] = $this->registry->get('errorlist')->getUnique();
        
        $output = $this->render('Ilib/ErrorHandler/Observer/File/ErrorList/templates/errorlist-rss-tpl.php', $data);
        
        $response = new k_http_Response(200, $output);
        $response->setEncoding(NULL);
        $response->setContentType("Content-Type: application/rss+xml");

        throw $response;
    }
}
