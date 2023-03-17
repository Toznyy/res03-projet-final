# ROUTES

## USERS

### Général
- `/`
- `/a-propos`
- `/contact`
- `/connexion`
- `/creation`

### Catégories et articles
- `/liste-categories` (category = manga)
- `/liste-categories/:category`
- `/liste-categories/:category/:article`

### Nouveautés
- `/nouveautes`

## ADMIN

### Utilisateur
- `/admin/mon-compte`
- `/admin/mon-compte/modifier`
- `/admin/mon-compte/supprimer`
- `/admin/mon-compte/favorites`

### Categories
- `/admin/categories`
- `/admin/categories/ajouter`
- `/admin/categories/:id/details`
- `/admin/categories/:id/modifier`
- `/admin/categories/:id/supprimer`

### Articles
- `/admin/articles`
- `/admin/articles/ajouter`
- `/admin/articles/:id/details`
- `/admin/articles/:id/modifier`
- `/admin/articles/:id/supprimer`

### Nouveautés
- `/admin/nouveautes`
- `/admin/nouveautes/ajouter`
- `/admin/nouveautes/:article/modifier`
- `/admin/nouveautes/:article/details`
- `/admin/nouveautes/:article/supprimer`

### Médias
- `/admin/medias`
- `/admin/medias/ajouter`
- `/admin/medias/:id/supprimer`

### Commandes
- `/panier`
- `/admin/orders`
- `/admin/orders/:id/modifier`
- `/admin/orders/:id/details`
- `/admin/orders/:id/supprimer`
