# Controllers

## PageController

### Routes publiques
- `/`
- `/a-propos`
- `/contact`

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

## NouveautesController

### Routes publiques
- `/nouveautes`

### Routes privées

- `/admin/nouveautes`
- `/admin/nouveautes/ajouter`
- `/admin/nouveautes/:article/modifier`
- `/admin/nouveautes/:article/details`
- `/admin/nouveautes/:article/supprimer`


## MediaController

### Routes privées

- `/admin/medias`
- `/admin/medias/ajouter`
- `/admin/medias/:id/supprimer`
