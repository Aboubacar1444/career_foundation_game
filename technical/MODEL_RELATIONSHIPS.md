# MODEL RELATIONSHIPS — V0

```mermaid
erDiagram
    PLAYER ||--|| CHARACTER : controls
    CHARACTER ||--|| CAREER : has
    COUNTRY ||--o{ CITY : contains
    COUNTRY ||--o{ MARKET : exposes
    COUNTRY ||--o{ CHARACTER : origin
    CITY ||--o{ CHARACTER : home
    CHARACTER ||--o{ CHARACTER_SKILL : develops
    SKILL ||--o{ CHARACTER_SKILL : assigned
    PROFESSIONAL_GRADE ||--o{ CAREER : classifies
    CHARACTER ||--o{ CHARACTER_UNLOCK : earns
    UNLOCK ||--o{ CHARACTER_UNLOCK : grants
    CHARACTER ||--o{ SONG : creates
    GENRE ||--o{ SONG : classifies
    SONG ||--o{ RELEASE : has
    SONG ||--o{ SONG_STREAM_STAT : receives
    STREAMING_PLATFORM ||--o{ SONG_STREAM_STAT : measures
    MARKET ||--o{ SONG_STREAM_STAT : measures
    CHARACTER ||--o{ CHARACTER_MARKET_AUDIENCE : builds
    MARKET ||--o{ CHARACTER_MARKET_AUDIENCE : contains
    AUDIENCE_SEGMENT ||--o{ CHARACTER_MARKET_AUDIENCE : segments
    CHARACTER ||--o{ GAME_ACTION : starts
    CHARACTER ||--o{ QUEST_INSTANCE : follows
    QUEST_DEFINITION ||--o{ QUEST_INSTANCE : instantiates
    QUEST_INSTANCE ||--o{ QUEST_OBJECTIVE_PROGRESS : tracks
    QUEST_DEFINITION ||--o{ QUEST_OBJECTIVE : defines
    CHARACTER ||--o{ CONCERT : performs
    VENUE ||--o{ CONCERT : hosts
    CITY ||--o{ VENUE : contains
    CHARACTER ||--o{ TOUR : performs
    TOUR ||--o{ TOUR_STOP : contains
    VENUE ||--o{ TOUR_STOP : hosts
    CERTIFICATION_DEFINITION ||--o{ CERTIFICATION_AWARD : awards
    CHARACTER ||--o{ CERTIFICATION_AWARD : receives
    CHARACTER ||--o{ WALLET : owns
    WALLET ||--o{ TRANSACTION : records
```

## Design notes
- `origin_country` is permanent identity.
- `market` represents access and career presence; it is not equivalent to relocation.
- `game_action` is the generic foundation for timed work such as recording, concerts and tours.
- `event_instance` and `player_event` separate global scheduling from player-specific progress.
- XP/level and professional grade are intentionally separated.
