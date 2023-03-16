<?php

class PageController extends AbstractController {
    private PageManager $pam;
    
    public function __construct() {
        
        $this->pam = new PageManager();
    }
    
    public function connexion() {
        $this->render( "connexion" , ["page de connexion"]);
    }
    
    public function creation() {
        $this->render( "creation" , ["page de la création de compte"]); 
    }
    
    public function contact() {
        $this->render( "contact" , ["page de contact"]); 
    }
    
    public function aPropos() {
        $this->render( "info" , ["page d'info"]); 
    }
    
    public function accueil() {
        $this->render( "accueil" , ["page d'accueil"]); 
    }
    
    public function nouveautes() {
        $this->render( "nouveautes" , ["page des nouveautes"]); 
    }
    
    public function listeCategories() {
        $this->render( "liste-categories" , ["page de la liste des catégories"]); 
    }
    
    public function error404() {
        $this->render( "404" , ["page du 404"]); 
    }
}

?>