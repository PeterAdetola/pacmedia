#!/bin/bash

echo "🚀 Laravel Sail Project Setup"

# Start Sail
echo "🐳 Starting Docker containers..."
./vendor/bin/sail up -d

# Wait for MySQL to be healthy
echo "⏳ Waiting for MySQL to be ready..."
sleep 10

# Install dependencies
echo "📦 Installing Composer dependencies..."
./vendor/bin/sail composer install

echo "📦 Installing NPM dependencies..."
./vendor/bin/sail npm install

# Generate key
echo "🔑 Generating application key..."
./vendor/bin/sail artisan key:generate

# Run migrations
echo "🗄️  Running database migrations..."
./vendor/bin/sail artisan migrate

# Create storage link
echo "🔗 Creating storage link..."
./vendor/bin/sail artisan storage:link

# Clear caches
echo "🧹 Clearing caches..."
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan cache:clear

echo ""
echo "✅ Setup complete!"
echo "📝 Access your application at:"
echo "   - http://localhost:8000"
echo "   - http://localhost:8081 (via NGINX)"
echo ""
echo "💡 To start Vite dev server: sail npm run dev"
