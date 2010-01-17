<?php

class Ilib_ErrorHandler_Observer_File_ErrorList_Controller_Index extends k_Component
{
    protected $errorlist;
    protected $translation;
    protected $template;

    function __construct(Ilib_ErrorHandler_Observer_File_ErrorList $list, Translation2_Admin $translation, k_TemplateFactory $template)
    {
        $this->errorlist = $list;
        $this->translation = $translation;
        $this->template = $template;
    }

    function renderHtml()
    {
        if ($this->query('unique')) {
            $data['items'] = $this->errorlist->getUnique();
        } else {
            $data['items'] = $this->errorlist->getAll();
        }

        try {
            $translation = $this->translation;
            $data['has_translation'] = true;
        }
        catch(ReflectionException $e) {
            $data['has_translation'] = false;
        }

        $tpl = $this->template->create('Ilib/ErrorHandler/Observer/File/ErrorList/templates/errorlist');
        return $tpl->render($this, $data);
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