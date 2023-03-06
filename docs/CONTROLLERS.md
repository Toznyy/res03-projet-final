# CONTROLLERS

## PageController

### Routes publiques
- `/`
- `/a-propos`
- `/contact`
- `/connexion`
- `/creation`

## CategoryController

### Routes publiques
- `/all-categories/:category`

### Routes privées
- `/admin/all-categories`
- `/admin/all-categories/ajouter`
- `/admin/all-categories/:id/details`
- `/admin/all-categories/:id/modifier`
- `/admin/all-categories/:id/supprimer`

## ArticleController

### Routes publiques
- `/all-articles`
- `/all-categories/:category/:article`

### Routes privées
- `/admin/all-articles`
- `/admin/all-articles/ajouter`
- `/admin/all-articles/:id/details`
- `/admin/all-articles/:id/modifier`
- `/admin/all-articles/:id/supprimer`

## NewsController

### Routes publiques
- `/nouveautes`

### Routes privées
- `/admin/nouveautes`
- `/admin/nouveautes/ajouter`
- `/admin/nouveautes/:article/modifier`
- `/admin/nouveautes/:article/details`
- `/admin/nouveautes/:article/supprimer`

## UserController

### Routes privées
- `/admin/mon-compte``
- `/admin/mon-compte/ajouter`
- `/admin/mon-compte/:article/modifier`
- `/admin/mon-compte/:article/details`
- `/admin/mon-compte/:article/supprimer`

## MediaController

### Routes privées
- `/admin/medias`
- `/admin/medias/ajouter`
- `/admin/medias/:id/modifier`
- `/admin/medias/:id/details`
- `/admin/medias/:id/supprimer`

## OrderController

### Routes publiques
- `/panier`

### Routes privées
- `/admin/orders`
- `/admin/orders/:id/modifier`
- `/admin/orders/:id/details`
- `/admin/orders/:id/supprimer`
