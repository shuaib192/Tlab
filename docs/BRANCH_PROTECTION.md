# Branch Protection & Release Process

## Branch Strategy

- `main` — Production. Protected. No direct pushes. Only PRs from `develop`.
- `develop` — Staging. Protected. PRs from `feature/*` branches.
- `feature/*` — New features. Branch from `develop`, merge back via PR.
- `hotfix/*` — Emergency fixes. Branch from `main`, merge to `main` and `develop`.

## PR Requirements (must pass before merge to `develop` or `main`)

1. All CI checks pass (lint + test)
2. At least 1 reviewer approval
3. No `dd()` / `dump()` / `ray()` calls
4. Feature flag wrapped if it's a staging-only feature

## Release Process

1. Feature complete → PR `feature/*` → `develop`
2. Test on staging: `https://staging.tlab.edfrica.org`
3. Selected users test via feature flags
4. QA sign-off → PR `develop` → `main`
5. Auto-deployed to production via GitHub Actions

## Setting Up Branch Protection on GitHub

1. Go to repo → Settings → Branches → Add rule
2. For `main`:
   - Require PR with 1 approval
   - Dismiss stale reviews
   - Require status checks (lint, test)
   - Require linear history
   - No direct push
3. For `develop`:
   - Require PR with 1 approval
   - Require status checks
   - No direct push
