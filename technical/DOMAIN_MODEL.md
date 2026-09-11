# DOMAIN MODEL — V0

## Aggregates

### Career aggregate
Owns progression state:
- XP
- internal level
- professional grade
- reputation
- popularity
- skills
- unlocks

### Music aggregate
Owns songs/releases and their measurable performance.

### Market presence aggregate
Owns audience, market access, local opportunities and country-specific progression.

### Action aggregate
Owns timed work and speed modifications.

### Quest aggregate
Owns main/secondary quest state and objective convergence.

### Event aggregate
Owns scheduled global events and player participation.

### Economy aggregate
Owns wallet, transactions and speed resources.

## Invariants
1. Money changes are transaction-backed.
2. Professional unlocks are server-validated.
3. Origin country is never overwritten by international expansion.
4. XP and historical achievements are not erased by career decline.
5. An AI-generated event cannot directly mutate core economy/progression without passing through domain rules.
6. Clients cannot set final streaming, reputation, XP or financial results directly.
