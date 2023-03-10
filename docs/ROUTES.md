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
- `/admin/mon-compte/ajouter`
- `/admin/mon-compte/:article/modifier`
- `/admin/mon-compte/:article/details`
- `/admin/mon-compte/:article/supprimer`

### Categories
- `/admin/all-categories`
- `/admin/all-categories/ajouter`
- `/admin/all-categories/:id/details`
- `/admin/all-categories/:id/modifier`
- `/admin/all-categories/:id/supprimer`

### Articles
- `/admin/all-articles`
- `/admin/all-articles/ajouter`
- `/admin/all-articles/:id/details`
- `/admin/all-articles/:id/modifier`
- `/admin/all-articles/:id/supprimer`

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
