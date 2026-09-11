# TIME ENGINE — V0

## Goal
Provide deterministic server-side resolution for long-running actions without maintaining a simulated offline world.

## Action lifecycle
`CREATED → RUNNING → SPEED_MODIFIED* → READY → RESOLVED`

## Completion timestamp
`effective_completion = min(original_completion - speed_reduction, server_now)`

An action cannot resolve before its effective completion timestamp.

## Speed rules
- speeders reduce duration;
- multiple speeders must follow a capped/validated rule;
- no speed operation may bypass eligibility, quest prerequisites or professional-grade requirements.

## Fast interactions
The client may present a lightweight resolution sequence for long actions. The server remains authoritative and records only the meaningful milestones/results.

## Concert example
A concert can represent several real-world hours while resolving through a fast sequence of phases. Optional concert quests can add interactive objectives without requiring real-time minute-by-minute play.
