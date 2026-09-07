# 29 — TIME SYSTEM

## Objectif
Créer un monde persistant sans transformer la durée en attente frustrante.

## Modèle : temps hybride
Trois couches coexistent :
1. temps réel du monde ;
2. durée simulée des actions ;
3. accélération contrôlée.

## Temps réel du monde
Le serveur conserve une référence temporelle et fait avancer certains systèmes : streams, charts, marchés, contrats, tendances, événements et activités NPC.

## Durée simulée
Une action possède une durée de simulation. Exemple : studio 4 h, concert 2 h 30, voyage 6 h, tournée 5 jours.

Le joueur ne doit pas attendre autant devant son écran. L'action est résolue par étapes ou au prochain état pertinent.

## Accélération
Une action peut être accélérée par :
- accélérateurs gagnés en jeu ;
- ressources gratuites ;
- améliorations de bâtiment/équipement ;
- premium, dans des limites d'équilibrage.

## Règle d'engagement
L'accélération payante ou gagnée réduit le temps d'une action ; elle ne supprime pas les prérequis structurels d'une carrière.

## Hors connexion
À la reconnexion, le serveur calcule ce qui s'est passé depuis le dernier état connu et affiche un résumé : revenus, streams, variations de charts, événements, messages et actions qui nécessitent une décision.

## Temps critique
Certaines échéances peuvent utiliser une fenêtre réelle : appel média, négociation, mise en vente, événement hebdomadaire. Une absence ne doit cependant pas rendre une carrière irrécupérable.
