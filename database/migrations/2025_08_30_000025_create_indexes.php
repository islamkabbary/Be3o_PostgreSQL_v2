<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // User table indexes
        DB::statement('CREATE INDEX idx_users_email ON users(email);');
        DB::statement('CREATE INDEX idx_users_phone ON users(phone);');
        DB::statement('CREATE INDEX idx_users_account_status ON users(account_status);');
        DB::statement('CREATE INDEX idx_users_created_at ON users(created_at DESC);');

        // Listing table indexes
        DB::statement('CREATE INDEX idx_listings_user_id ON listings(user_id);');
        DB::statement('CREATE INDEX idx_listings_status ON listings(status);');
        DB::statement('CREATE INDEX idx_listings_location ON listings(governorate, city, area);');
        DB::statement('CREATE INDEX idx_listings_price ON listings(price);');
        DB::statement('CREATE INDEX idx_listings_priority_score ON listings(priority_score DESC);');
        DB::statement('CREATE INDEX idx_listings_created_at ON listings(created_at DESC);');
        DB::statement('CREATE INDEX idx_listings_published_at ON listings(published_at DESC);');
        DB::statement('CREATE INDEX idx_listings_expires_at ON listings(expires_at);');

        // Full-text search indexes
        DB::statement('CREATE INDEX idx_listings_title_gin ON listings USING gin(to_tsvector(\'arabic\', title));');
        DB::statement('CREATE INDEX idx_listings_description_gin ON listings USING gin(to_tsvector(\'arabic\', description));');

        // Spatial indexes
        DB::statement('CREATE INDEX idx_listings_location_gist ON listings USING gist(location);');
        DB::statement('CREATE INDEX idx_user_addresses_location_gist ON user_addresses USING gist(location);');

        // Message system indexes
        DB::statement('CREATE INDEX idx_conversations_buyer_seller ON conversations(buyer_id, seller_id);');
        DB::statement('CREATE INDEX idx_conversations_listing ON conversations(listing_id);');
        DB::statement('CREATE INDEX idx_messages_conversation_sent_at ON messages(conversation_id, sent_at DESC);');
        DB::statement('CREATE INDEX idx_messages_recipient_unread ON messages(recipient_id, is_read, sent_at DESC);');

        // Favorites and searches
        DB::statement('CREATE INDEX idx_favorites_user_listing ON favorites(user_id, listing_id);');
        DB::statement('CREATE INDEX idx_favorites_listing ON favorites(listing_id);');

        // Reviews and ratings
        DB::statement('CREATE INDEX idx_reviews_reviewee_rating ON reviews(reviewee_id, rating, created_at DESC);');
        DB::statement('CREATE INDEX idx_reviews_listing ON reviews(listing_id);');

        // Notification indexes
        DB::statement('CREATE INDEX idx_notifications_user_unread ON notifications(user_id, is_read, created_at DESC);');

        // Subscriptions indexes
        DB::statement('CREATE INDEX idx_subscriptions_user_status ON subscriptions(user_id, status);');
        DB::statement('CREATE INDEX idx_subscription_plans_type ON subscription_plans(plan_type);');

    }

    public function down(): void
    {
        // Drop indexes in reverse order
        DB::statement('DROP INDEX IF EXISTS idx_subscription_plans_type;');
        DB::statement('DROP INDEX IF EXISTS idx_subscriptions_user_status;');
        DB::statement('DROP INDEX IF EXISTS idx_notifications_user_unread;');
        DB::statement('DROP INDEX IF EXISTS idx_reviews_listing;');
        DB::statement('DROP INDEX IF EXISTS idx_reviews_reviewee_rating;');
        DB::statement('DROP INDEX IF EXISTS idx_favorites_listing;');
        DB::statement('DROP INDEX IF EXISTS idx_favorites_user_listing;');
        DB::statement('DROP INDEX IF EXISTS idx_messages_recipient_unread;');
        DB::statement('DROP INDEX IF EXISTS idx_messages_conversation_sent_at;');
        DB::statement('DROP INDEX IF EXISTS idx_conversations_listing;');
        DB::statement('DROP INDEX IF EXISTS idx_conversations_buyer_seller;');
        DB::statement('DROP INDEX IF EXISTS idx_user_addresses_location_gist;');
        DB::statement('DROP INDEX IF EXISTS idx_listings_location_gist;');
        DB::statement('DROP INDEX IF EXISTS idx_listings_description_gin;');
        DB::statement('DROP INDEX IF EXISTS idx_listings_title_gin;');
        DB::statement('DROP INDEX IF EXISTS idx_listings_expires_at;');
        DB::statement('DROP INDEX IF EXISTS idx_listings_published_at;');
        DB::statement('DROP INDEX IF EXISTS idx_listings_created_at;');
        DB::statement('DROP INDEX IF EXISTS idx_listings_priority_score;');
        DB::statement('DROP INDEX IF EXISTS idx_listings_price;');
        DB::statement('DROP INDEX IF EXISTS idx_listings_location;');
        DB::statement('DROP INDEX IF EXISTS idx_listings_status;');
        DB::statement('DROP INDEX IF EXISTS idx_listings_user_id;');
        DB::statement('DROP INDEX IF EXISTS idx_users_created_at;');
        DB::statement('DROP INDEX IF EXISTS idx_users_account_status;');
        DB::statement('DROP INDEX IF EXISTS idx_users_phone;');
        DB::statement('DROP INDEX IF EXISTS idx_users_email;');
    }
};