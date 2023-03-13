<?php

class PageController extends AbstractController {
    private PageManager $pam;
    
    public function __construct() {
        
        $this->pam = new PageManager();
    }
    
    public function connexion() {
        $this->renderPublic( "connexion" , ["page de connexion"]);
    }
    
    public function creation() {
        $this->renderPublic( "creation" , ["page de la création de compte"]); 
    }
    
    public function contact() {
        $this->renderPublic( "contact" , ["page de contact"]); 
    }
    
    public function aPropos() {
        $this->renderPublic( "info" , ["page d'info"]); 
    }
    
    public function acceuil() {
        $this->renderPublic( "homepage" , ["page d'acceuil"]); 
    }
    
    public function nouveautes() {
        $this->renderPublic( "nouveautes" , ["page des nouveautes"]); 
    }
    
    public function listeCategories() {
        $this->renderPublic( "liste-categories" , ["page de la liste des catégories"]); 
    }
    
    public function error404() {
        $this->renderPublic( "404" , ["page du 404"]); 
    }
    
}

?>