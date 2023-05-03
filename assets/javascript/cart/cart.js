function initCart() {

    let buttons = document.getElementsByClassName("paniers");

    for (let i = 0; i < buttons.length; i++) {

        let id = buttons[i].getAttribute("data-product-id");
        let quantity = document.getElementById("quantity").value;
        buttons[i].addEventListener("click", function(event) {
            event.preventDefault();
            let formData = new FormData();
            formData.append('product_id', id);
            formData.append('quantity', quantity);
            
            const options = {
            	method: 'POST',
            	body: formData
            };
            
            fetch('/res03-projet-final/addPanier', options)
            .then(response => response.json())
            .then(data => {
            	console.log(data);
            	window.location.href = "/res03-projet-final/panier";
            });
        });
    }

}

export { initCart };
