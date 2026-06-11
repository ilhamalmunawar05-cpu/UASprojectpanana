# SIPERPUS Git & Branch Strategy

## Branch Organization

### Main Branches
- **main** - Production-ready code
- **develop** - Integration branch untuk development (optional)

### Feature Branches
Format: `feature/description`

Examples:
```
feature/integrate-bookmaster        ✅ COMPLETED
feature/user-authentication
feature/book-management
feature/exhibition-system
feature/admin-dashboard
feature/payment-integration
```

### Bug Fix Branches
Format: `bugfix/issue-description`

Examples:
```
bugfix/fix-login-validation
bugfix/fix-responsive-design
bugfix/fix-database-migration
```

### Hotfix Branches
Format: `hotfix/critical-issue`

Examples:
```
hotfix/security-vulnerability
hotfix/data-loss-issue
hotfix/deployment-error
```

## Branch Workflow

### 1. Create Feature Branch
```bash
# Ensure main branch is updated
git checkout main
git pull origin main

# Create feature branch
git checkout -b feature/nama-fitur

# Or create directly
git checkout -b feature/nama-fitur origin/main
```

### 2. Work on Feature
```bash
# Make changes and commit regularly
git add .
git commit -m "feat: Descriptive commit message"

# Push to remote
git push origin feature/nama-fitur
```

### 3. Commit Message Convention
```
format: message

body (optional):
- Point 1
- Point 2

footer (optional):
Closes #issue-number
```

Examples:
```
feat: Add user registration form

- Created registration controller
- Added email validation
- Integrated email sending service

Closes #42

---

fix: Fix dropdown menu alignment

The dropdown was misaligned on mobile devices.
Updated CSS media query to fix the issue.

---

docs: Update API documentation

Added endpoint descriptions and examples
```

### 4. Commit Types
- `feat:` - New feature
- `fix:` - Bug fix
- `docs:` - Documentation
- `style:` - Code style (formatting, semicolons, etc)
- `refactor:` - Code refactoring
- `perf:` - Performance improvement
- `test:` - Adding/updating tests
- `chore:` - Build, dependencies, etc

### 5. Pull Request & Review
```bash
# Push final changes
git push origin feature/nama-fitur

# Create PR on GitHub
# - Title: [TYPE] Brief description
# - Description: What changes, why, how to test
# - Link issue if applicable

# After review and approval
git checkout main
git pull origin main
git merge feature/nama-fitur
git push origin main
```

### 6. Delete Branch
```bash
# Delete local branch
git branch -d feature/nama-fitur

# Delete remote branch
git push origin -d feature/nama-fitur

# Or on GitHub UI
```

## Current Project Branches

### Active Branches
```
main
  └── production-ready code
      
feature/integrate-bookmaster ✅ COMPLETED
  ├── Integrated Book Master template
  ├── Created Blade layouts
  ├── Organized public assets
  └── Ready for merge to main
```

### Upcoming Features (Suggested Branches)
```
feature/admin-dashboard
  - Admin control panel
  - Dashboard statistics
  - User management

feature/book-module
  - Book catalog
  - Search functionality
  - Book details page

feature/exhibition-module
  - Exhibition management
  - Exhibition listing
  - Gallery integration

feature/user-profile
  - User profile page
  - Account settings
  - Preference management

feature/api-endpoints
  - REST API
  - Authentication tokens
  - CORS configuration

feature/mobile-app-support
  - API optimization
  - Response formatting
  - Token management
```

## Example Development Flow

### Scenario: Adding New Feature

```bash
# Step 1: Start from main
git checkout main
git pull origin main

# Step 2: Create feature branch
git checkout -b feature/book-search

# Step 3: Make changes (in multiple commits)
# - Create controller
git add app/Http/Controllers/Public/BookController.php
git commit -m "feat: Create BookController with search method"

# - Create views
git add resources/views/bookmaster/books/
git commit -m "feat: Add book search views"

# - Create routes
git add routes/web.php
git commit -m "feat: Add book search routes"

# Step 4: Test locally
# php artisan serve
# Test in browser

# Step 5: Push to remote
git push origin feature/book-search

# Step 6: Create PR on GitHub
# Request review from team

# Step 7: After approval, merge
git checkout main
git pull origin main
git merge feature/book-search
git push origin main

# Step 8: Cleanup
git branch -d feature/book-search
git push origin -d feature/book-search
```

## Common Commands

### View Branches
```bash
# List local branches
git branch

# List remote branches
git branch -r

# List all branches (local + remote)
git branch -a
```

### Switch Between Branches
```bash
# Switch to existing branch
git checkout branch-name

# Create and switch
git checkout -b new-branch-name

# Switch to previous branch
git checkout -
```

### Sync with Main
```bash
# Before starting work
git pull origin main

# While on feature branch, update from main
git fetch origin
git rebase origin/main

# Or merge (if conflicts, easier)
git merge origin/main
```

### Check Status
```bash
# See current branch and changes
git status

# See commit history
git log --oneline

# See changes in current branch vs main
git diff main..feature/branch-name
```

### Undo Changes
```bash
# Discard local changes (be careful!)
git checkout -- filename

# Undo last commit (keep changes)
git reset --soft HEAD~1

# Undo last commit (discard changes)
git reset --hard HEAD~1

# Undo last commit on remote (use with caution!)
git revert HEAD
```

## Best Practices

### ✅ DO:
- ✅ Create new branch untuk setiap fitur
- ✅ Make small, focused commits
- ✅ Write clear commit messages
- ✅ Pull latest changes sebelum push
- ✅ Test locally sebelum push
- ✅ Create PR untuk code review
- ✅ Delete branch setelah merge
- ✅ Keep branches up-to-date dengan main
- ✅ Use descriptive branch names
- ✅ Commit early, commit often

### ❌ DON'T:
- ❌ Commit directly to main
- ❌ Use vague branch names (update, fix, etc)
- ❌ Write cryptic commit messages
- ❌ Forget to pull before push
- ❌ Mix multiple features in one branch
- ❌ Leave branches dangling after merge
- ❌ Force push to shared branches
- ❌ Commit large binary files
- ❌ Hardcode credentials/passwords
- ❌ Skip testing before push

## Conflict Resolution

### If Merge Conflict Occurs
```bash
# See conflicted files
git status

# Open file and resolve conflicts
# <<<<<<< HEAD
# current branch code
# =======
# incoming branch code
# >>>>>>> feature-branch

# After resolving
git add conflicted-file
git commit -m "chore: Resolve merge conflict"
git push origin feature-branch
```

## Release Process

```bash
# 1. Create release branch
git checkout -b release/v1.0.0 develop

# 2. Update version, changelog
# Commit: "chore: Release v1.0.0"

# 3. Merge to main
git checkout main
git merge --no-ff release/v1.0.0
git tag -a v1.0.0 -m "Release version 1.0.0"

# 4. Merge back to develop
git checkout develop
git merge --no-ff release/v1.0.0

# 5. Delete release branch
git branch -d release/v1.0.0

# 6. Push everything
git push origin main develop --tags
```

## Team Guidelines

### Before Starting Work
1. Check current issues/PRs
2. Discuss with team if major changes
3. Ensure main is up-to-date
4. Create feature branch from latest main

### While Working
1. Keep commits atomic (one thing per commit)
2. Test changes locally
3. Push frequently (at least daily)
4. Update PR with progress

### Before Submitting PR
1. Ensure all tests pass
2. Verify responsive design
3. Check for console errors
4. Rebase onto latest main if needed
5. Write descriptive PR description

### During Code Review
1. Be open to feedback
2. Make requested changes
3. Push updates to same PR (auto-updates)
4. Ask for clarification if unsure

### After Merge
1. Verify deployment successful
2. Test on production-like environment
3. Delete feature branch
4. Update related issues/tickets

---

**Last Updated**: 2026-06-11
**Team**: SIPERPUS Development Team
**Workflow**: Feature-based branching
