#!/bin/bash

# Git Commit Distribution Script
# This script distributes your pending changes across specified dates

set -e  # Exit on error

echo "🚀 Starting Git Commit Distribution..."
echo "⚠️  WARNING: This will reset your current staging area!"
read -p "Do you want to continue? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "Aborted."
    exit 0
fi

# Reset staging area
echo "📦 Resetting staging area..."
git reset

# Date: 2025-11-01
echo "📅 Processing commits for 2025-11-01..."
git add public/images/logo.png resources/views/emails/otp.blade.php
git commit -m "Add company logo and update OTP email template" --date="2025-11-01 09:30:00"

git add app/Mail/WelcomeMail.php app/Http/Controllers/EmailController.php resources/views/emails/welcome.blade.php
git commit -m "Implement welcome email functionality" --date="2025-11-01 14:45:00"

# Date: 2025-11-02
echo "📅 Processing commits for 2025-11-02..."
git add resources/js/pages/ForgotPassword.vue
git commit -m "Add forgot password page component" --date="2025-11-02 10:15:00"

git add resources/js/composables/useAuth.js
git commit -m "Enhance authentication composable with password reset support" --date="2025-11-02 15:20:00"

# Date: 2025-11-03
echo "📅 Processing commits for 2025-11-03..."
git add resources/js/pages/Login.vue
git commit -m "Update login page UI and add forgot password link" --date="2025-11-03 11:00:00"

git add resources/js/router/index.js
git commit -m "Add forgot password route to router configuration" --date="2025-11-03 16:30:00"

# Date: 2025-11-08
echo "📅 Processing commits for 2025-11-08..."
git add routes/api.php
git commit -m "Add API routes for email and password reset functionality" --date="2025-11-08 09:45:00"

git add resources/js/services/api.js
git commit -m "Extend API service with new authentication endpoints" --date="2025-11-08 14:00:00"

# Date: 2025-11-09
echo "📅 Processing commits for 2025-11-09..."
git add app/Http/Controllers/AdminDashboardController.php
git commit -m "Implement admin dashboard controller" --date="2025-11-09 10:30:00"

git add app/Http/Controllers/AdminApplicationController.php
git commit -m "Add admin application management controller" --date="2025-11-09 15:45:00"

# Date: 2025-11-11
echo "📅 Processing commits for 2025-11-11..."
git add app/Http/Controllers/ApplicationController.php
git commit -m "Refactor application controller with improved validation" --date="2025-11-11 11:15:00"

git add resources/js/pages/Dashboard.vue
git commit -m "Enhance dashboard with admin features and statistics" --date="2025-11-11 16:00:00"

# Date: 2025-11-12
echo "📅 Processing commits for 2025-11-12..."
git add resources/js/pages/CreateApplication.vue
git commit -m "Improve create application form with better UX" --date="2025-11-12 09:30:00"

git add resources/js/pages/Students.vue
git commit -m "Add filtering and search functionality to students page" --date="2025-11-12 14:45:00"

# Date: 2025-11-13
echo "📅 Processing commits for 2025-11-13..."
git add resources/js/components/Navigation.vue
git commit -m "Update navigation with admin menu items" --date="2025-11-13 10:00:00"

git add resources/js/app.js
git commit -m "Configure app with new components and global settings" --date="2025-11-13 15:30:00"

# Date: 2025-11-14
echo "📅 Processing commits for 2025-11-14..."
git add composer.json
git commit -m "Update composer dependencies for email functionality" --date="2025-11-14 11:45:00"

# Check if there are any remaining unstaged changes
if [[ -n $(git status -s) ]]; then
    echo "📦 Committing any remaining changes..."
    git add .
    git commit -m "Final integration and cleanup" --date="2025-11-14 16:15:00"
fi

echo ""
echo "✅ All commits created successfully!"
echo ""
echo "📊 Commit Summary:"
git log --oneline --graph --date=short --pretty=format:'%h - %ad : %s' -20

echo ""
echo ""
echo "🚀 Ready to push to remote?"
echo "   Run: git push origin main"
read -p "Push now? (yes/no): " push_confirm

if [ "$push_confirm" = "yes" ]; then
    git push origin main
    echo "✅ Pushed to remote successfully!"
else
    echo "ℹ️  Commits created locally. Push when ready with: git push origin main"
fi

echo ""
echo "🎉 Done!"
