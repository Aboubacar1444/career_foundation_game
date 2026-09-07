# Database

## Entités cœur V0
Player, Character, Country, City, Career, Skill, Song, Release, PlatformMetric, FanSegment, ReputationEvent, Quest, QuestStep, GameEvent, Venue, Concert, Certification, Wallet, Transaction, TimeJob.

## Principes
- historique important conservé ;
- transactions financières auditables ;
- événements idempotents ;
- statistiques agrégées séparées des historiques lorsque la volumétrie augmente ;
- UUID partout où des identifiants publics sont exposés.
