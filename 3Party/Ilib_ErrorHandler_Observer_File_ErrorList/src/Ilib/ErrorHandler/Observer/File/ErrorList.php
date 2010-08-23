<?php
/*
 * To display all errors
 */
class Ilib_ErrorHandler_Observer_File_ErrorList
{
    private $error_log;

    function __construct($filename)
    {
        $this->error_file = $filename;
    }
    
    private function getRawErrorList()
    {
        if (!file_exists($this->error_file)) {
            throw new Exception('Error log not found ' . $this->error_file);
        }
        
        $errors = file($this->error_file);
        return $errors;
    }
    
    public function getAll()
    {
        return $this->getParsedErrorList();
    }
    
    public function getUnique()
    {
        return $this->getParsedErrorList(true);
    }
    
    private function getParsedErrorList($only_unique = false)
    {
        $errors = $this->getRawErrorList();

        $unique = array();
        $items = array();

        if(!empty($errors)) {
            foreach ($errors AS $error_string) {
                // /modules/debtor/list.php?text=&status=2&sorting=0&from_date=01-06-2009&to_date=31-06-2009&type=invoice&contact_id=&product_id=&search=Find
                if(!ereg("^([a-zA-Z]{3} [0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}) ([a-zA-Z0-9]+) \[([a-zA-Z0-9]+)\] ([a-zA-Z0-9]+): (.+) in ([][a-zA-Z0-9/\_.-]*) line ([][a-zA-Z0-9]*) \(Request: ([][a-zA-Z0-9/\._%+&?\=-]*)\)", $error_string, $params)) {
                    $error['message'] = 'Unable to parse error line!';
                    $error['date'] = date(DATE_RFC822);
                    $error['type'] = 'Internal';
                    $error['file'] = '[not given]';
                    $error['line'] = '[not given]';
                    $error['request'] = '[not given]';
                } else {
                    $error['date'] = (isset($params[1])) ? date(DATE_RFC822, strtotime($params[1])) : date(DATE_RFC822);

                    $error['type'] = '';
                    // We choose not to use PEAR log identifier [2] and PEAR error type [3] as they are the same so fare
                    // if(isset($params[2])) $error['type'] .= $params[2].' ';
                    // if(isset($params[3])) $error['type'] .= '['.$params[3].'] ';
                    if(isset($params[4])) $error['type'] .= $params[4];
    
                    $error['message'] = (isset($params[5])) ? $params[5] : '[no message]';
                    $error['file'] = (isset($params[6])) ? $params[6] : '[not given]';
                    $error['line'] = (isset($params[7])) ? $params[7] : '[not given]';
                    $error['request'] = (isset($params[8])) ? $params[8] : '[not given]';
                }
                
                $unique_key = md5($error['type'].$error['message'].$error['file'].$error['line']);
                if($only_unique && in_array($unique_key, $unique)) {
                    continue;
                }
                $unique[] = $unique_key;

                if($error['file'] == '') {
                    $error['file'] = 'URL: '.$error['request'];
                }

                $items[] = array(
                    'title' => $error['type'] . ': ' . $error['message'],
                    'description' => $error['file'] . ' - line ' . $error['line'],
                    'pubDate' => $error['date'], // RFC 822
                    'link' =>  $error['request'],
                    'author' => 'Intraface Developer Tools'
                );

            }
        }
        
        return $items;
    }

    public function delete()
    {
        unlink($this->error_file);
        touch($this->error_file);
    }

}
