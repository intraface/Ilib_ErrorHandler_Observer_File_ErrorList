<?php

abstract class Ilib_ErrorHandler_Observer_File_ErrorList_Controller_View extends k_Controller
{
    abstract function getErrorList();
    
    public function GET()
    {
        $data['items'] = $this->getErrorList();
        try {
            $translation = $this->registry->get('translation_admin');
            $data['has_translation'] = true;
        }
        catch(ReflectionException $e) {
            $data['has_translation'] = false;
        }

        return $this->render('Ilib/ErrorHandler/Observer/File/ErrorList/templates/errorlist-tpl.php', $data);
    }
    
    public function POST()
    {
        $errorlist = $this->registry->get('errorlist');
        
        if (!empty($this->POST['deletelog'])) {
            $errorlist->delete();
        }
        
        return $this->GET();
    }
}