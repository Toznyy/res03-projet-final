<?php  
   
abstract class AbstractController  
{  
    protected function renderPublic(string $view, array $values) : void {
        
        $template = $view;
        $data = $values;
        
        require 'templates/layout.phtml';
    }
}

?>