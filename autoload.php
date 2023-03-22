<?php

require "services/Router.php";
require "controllers/admin/AbstractController.php";
require "managers/admin/AbstractManager.php";

require "models/User.php";
require "models/Category.php";
require "models/Product.php";
require "models/Order.php";
require "models/Picture.php";

require "controllers/public/PageController.php";
require "controllers/public/LoginController.php";
require "controllers/admin/UserController.php";
require "controllers/admin/CategoryController.php";
require "controllers/admin/ProductController.php";
require "controllers/admin/OrderController.php";

require "managers/public/PageManager.php";
require "managers/admin/UserManager.php";
require "managers/admin/CategoryManager.php";
require "managers/admin/PictureManager.php";
require "managers/admin/ProductManager.php";
require "managers/admin/OrderManager.php";

?>