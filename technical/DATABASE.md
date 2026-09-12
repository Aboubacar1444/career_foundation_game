
# DATABASE — FOUNDATION MODEL V0

PostgreSQL is the source of truth for persistent game state.

## Core identity

### player
Represents the account/user. Authentication concerns stay separate from the game domain where possible.

Fields:
- id
- external_user_id
- created_at
- updated_at

### character
Represents the in-game person.

Fields:
- id
- player_id
- first_name
- stage_name
- sex (`male|female`)
- origin_country_id
- home_city_id
- created_at
- updated_at

A player controls one primary character in V0. The schema must not make future multi-character/manager mode impossible.

## World

### country
- id
- code
- name
- currency_code
- default_language_id
- active

### city
- id
- country_id
- name
- market_size
- cost_index
- active

### market
Represents a playable music market. It may map to a country initially but remains its own entity so the design can support regional/genre markets later.

- id
- country_id
- name
- tier
- active

### language
- id
- code
- name

### genre
- id
- name
- active

## Career and progression

### career
- id
- character_id
- professional_grade_id
- reputation_score
- popularity_score
- experience_xp
- internal_level
- created_at
- updated_at

### professional_grade
- id
- code
- name
- rank_order
- min_level
- active

### skill
- id
- code
- name
- category
- max_value

### character_skill
- character_id
- skill_id
- value
- updated_at

### unlock
- id
- code
- name
- type
- requirements_json
- active

### character_unlock
- character_id
- unlock_id
- unlocked_at

## Music

### song
- id
- character_id
- title
- primary_genre_id
- quality_score
- originality_score
- commercial_potential
- status
- created_at

### release
- id
- song_id
- release_type (`single|ep|album`)
- release_at
- campaign_status

### streaming_platform
Fictional platform definitions.

- id
- code
- name
- platform_type

### song_stream_stat
Time-bucketed aggregate metrics.

- id
- song_id
- streaming_platform_id
- market_id
- period_start
- period_end
- streams
- revenue

## Audience

### audience_segment
- id
- code
- name

### character_market_audience
- character_id
- market_id
- segment_id
- fans
- engagement_score
- updated_at

## Events and quests

### event_definition
Defines reusable event types.

- id
- code
- name
- scope (`global|market|player`)
- schedule_rule
- requirements_json
- rewards_json
- active

### event_instance
- id
- event_definition_id
- starts_at
- ends_at
- world_state_snapshot_json

### player_event
- id
- event_instance_id
- character_id
- status
- progress_json
- result_json

### quest_definition
- id
- code
- name
- type (`main|secondary`)
- prerequisites_json
- rewards_json

### quest_instance
- id
- quest_definition_id
- character_id
- parent_quest_instance_id
- status
- progress_json
- started_at
- completed_at

### quest_objective
- id
- quest_definition_id
- code
- objective_type
- target_value
- metadata_json

### quest_objective_progress
- quest_instance_id
- quest_objective_id
- current_value
- completed_at

## Concerts and tours

### venue
- id
- city_id
- name
- capacity
- tier

### concert
- id
- character_id
- venue_id
- market_id
- scheduled_start_at
- scheduled_end_at
- simulation_duration_seconds
- actual_resolved_at
- status
- outcome_json

### tour
- id
- character_id
- tier (`local|national|regional|international|world`)
- starts_at
- ends_at
- status

### tour_stop
- id
- tour_id
- venue_id
- sequence_no
- scheduled_start_at
- scheduled_end_at
- status
- outcome_json

## Certification

### certification_definition
- id
- code
- name
- release_type
- threshold_type
- threshold_value
- market_scope

### certification_award
- id
- character_id
- certification_definition_id
- song_id nullable
- release_id nullable
- market_id nullable
- awarded_at

## Economy

### wallet
- id
- character_id
- currency_code
- balance

### transaction
- id
- wallet_id
- type
- amount
- reference_type
- reference_id
- created_at

Never mutate money silently: every balance-changing operation should have a transaction record.

### speed_token
- id
- character_id
- speed_type
- quantity
- source_type
- acquired_at

## Time / commands

### game_action
Long-running player actions are first-class records.

- id
- character_id
- action_type
- started_at
- expected_completion_at
- resolved_at
- speed_reduction_seconds
- status
- payload_json
- result_json

The server resolves actions using authoritative timestamps. No offline simulation engine is required.

## Important relationships

`player 1—1 character`

`character 1—1 career`

`character N—N skill`

`character N—N market audience`

`character 1—N song`

`song 1—N release`

`release/song N—N streaming platform through song_stream_stat`

`character 1—N game_action`

`character 1—N quest_instance`

`character 1—N concert`

`character 1—N tour`

`character 1—N certification_award`

`character 1—N wallet`
