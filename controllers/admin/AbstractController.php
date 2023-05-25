<?php  
   
abstract class AbstractController {
    
    protected function render(string $view, array $values) : void {
        
        $template = $view;
        $data = $values;
        
        require 'templates/layout.phtml';
    }
    
    protected function renderPrivate(string $view, array $values) : void {
        
        $template = $view;
        $data = $values;
        
        require 'templates/admin/admin-layout.phtml';
    }
    
    protected function clean(string $unsafe) : string {
        
        return htmlspecialchars($unsafe);
    }
}

?>