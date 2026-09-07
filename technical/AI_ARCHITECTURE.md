# AI Architecture

## Pipeline
Etat du jeu → règles de sélection → contexte structuré → LLM → sortie structurée → validation backend → présentation.

## World Director
Le directeur IA ne choisit pas arbitrairement les récompenses. Il sélectionne ou reformule des événements permis par un catalogue et leurs conditions.

## Character AI
Les PNJ ont une mémoire résumée et des objectifs internes. Les dialogues sont générés à partir de données autorisées.

## Coût
Privilégier une hiérarchie : logique déterministe pour les événements fréquents, IA seulement pour les moments où elle apporte une vraie valeur.
