# 29 — TIME SYSTEM

## Decision
The game uses **server-authoritative real time**. It does not run active gameplay simulation while the player is offline. Actions may represent long periods in the game world, but their interactive resolution is intentionally compressed.

## 1. Time model
The system uses three layers:

1. **Real-world clock** — authoritative server timestamp.
2. **Game/calendar time** — weeks, seasons and scheduled events.
3. **Action duration** — a simulated duration attached to an activity.

An action is persisted with a start timestamp, a base duration and an effective duration after modifiers. The app does not need to remain open for the action to be valid, but the game does not perform a full offline simulation of the world's entities.

## 2. Progressive time scale
Early-career actions are intentionally short. As professional responsibility grows, projects represent longer periods of work.

Examples:
- battle / interview: minutes;
- small recording session: minutes to a few hours;
- major release campaign: hours to days;
- national tour: several days;
- international project / world tour: weeks.

The player should experience the consequences of long activities without having to watch a timer continuously.

## 3. Fast resolution
Long activities are resolved through a short interactive sequence rather than a minute-by-minute simulation.

Example — concert:

`Preparation → Performance → Key moment(s) → Result`

A concert may represent 2–4 real-world hours in the game calendar, while the interactive resolution can take seconds.

The amount of interactive detail can depend on the activity, available quests/objectives and the player's use of speeders.

## 4. Speeders
Three sources are supported:

- **Earned speeders:** quests, achievements, weekly/world events and progression rewards.
- **Gameplay speeders:** better staff, equipment, facilities or management capabilities.
- **Premium speeders:** purchasable accelerators.

A speeder changes the effective completion timestamp of the action. It does not bypass career requirements, unlocks or eligibility rules.

## 5. World consistency when speeding
Speeding up an action does **not** create a separate timeline for the player.

The shared world remains governed by the same server clock. Markets, NPCs, rankings, scheduled events and other global systems are evaluated according to that clock; they are **not** required to be simulated minute-by-minute while an action is running.

When an action completes, the server evaluates the valid world state at that completion timestamp and resolves the action against it.

Example:

A national tour normally takes 5 game-days. A speeder reduces it to 2 game-days.

- The player's tour resolves at the earlier timestamp.
- Rankings, market conditions and scheduled events use the state applicable at that earlier timestamp.
- There is no private 5-day simulation running for this player.
- The player therefore receives the consequences of finishing earlier, including potentially different market conditions or event eligibility.

This keeps acceleration meaningful while preserving a single consistent world clock.

## 6. Offline return
When the player returns after an absence, the server reconciles only what is necessary from persisted actions, deadlines and scheduled systems. It does not replay an entire artificial world history tick by tick.

An absence must never silently create an unrecoverable career failure.

## 7. Weekly events
Weekly events are scheduled by server time. Their existence is predictable, while their content, objectives and opponents are adaptive.

The weekly calendar is fixed, but participation and progression are not tied to constant attendance. Recovery mechanisms are defined in `30_WEEKLY_EVENTS.md`.

## 8. Anti-FOMO
The system avoids:
- irreversible punishment for absence;
- mandatory daily attendance;
- rewards that require constant monitoring;
- deadlines that destroy long-term progression.

Participation can provide advantages, but missing a window must not invalidate a career.
