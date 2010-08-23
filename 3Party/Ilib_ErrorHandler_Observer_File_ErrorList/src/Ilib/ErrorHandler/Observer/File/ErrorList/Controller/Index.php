<?php

class Ilib_ErrorHandler_Observer_File_ErrorList_Controller_Index extends k_Component
{
    protected $errorlist;
    protected $template;

    function __construct(Ilib_ErrorHandler_Observer_File_ErrorList $list, k_TemplateFactory $template)
    {
        $this->errorlist = $list;
        $this->template = $template;
    }

    function renderHtml()
    {
        try {
            if ($this->query('unique')) {
                $data['items'] = $this->errorlist->getUnique();
            } else {
                $data['items'] = $this->errorlist->getAll();
            }
        } catch (Exception $e) {
            $data['message'] = 'We where unable to get the errors. Either there is none or the path is not correct. We got the message "'.$e->getMessage().'"';
            $data['items'] = array();
        }

        $data['path_to_translation'] = $this->getPathToTranslation();
        
        $tpl = $this->template->create('Ilib/ErrorHandler/Observer/File/ErrorList/templates/errorlist');
        return $tpl->render($this, $data);
    }
    
    public function getPathToTranslation()
    {
        if(is_callable(array($this->context, 'getPathToTranslation'))) {
            return $this->context->getPathToTranslation();
        }
        
        return '';
    }

    function renderXml()
    {
        if ($this->query('unique')) {
            $data['items'] = $this->errorlist->getUnique();
        } else {
            $data['items'] = $this->errorlist->getAll();
        }

        $tpl = $this->template->create('Ilib/ErrorHandler/Observer/File/ErrorList/templates/errorlist-rss');
        $output = $tpl->render($this, $data);

        $response = new k_HttpResponse(200, $output);
        $response->setContentType("Content-Type: application/rss+xml");

        return $response;
    }

    public function postForm()
    {
        if ($this->body('deletelog')) {
            $this->errorlist->delete();
        }

        return new k_SeeOther($this->url());
    }
}