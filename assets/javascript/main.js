import { initCart } from "./cart/cart.js";
import { registerValidationForm } from "/res03-projet-final/assets/javascript/validate/registerValidation.js";
import { loginValidationForm } from "/res03-projet-final/assets/javascript/validate/loginValidation.js";
import { scroll } from "/res03-projet-final/assets/javascript/scroll/scroll.js";
window.addEventListener("DOMContentLoaded",function(){
    initCart();
    scroll();

    if(window.location.href === "https://anthonycormier.sites.3wa.io/res03-projet-final/creation"){
        registerValidationForm(event);
    }
    
    else if(window.location.href === "https://anthonycormier.sites.3wa.io/res03-projet-final/connexion"){
        loginValidationForm(event);
    }
});