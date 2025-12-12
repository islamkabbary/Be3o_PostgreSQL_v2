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

        // Ad table indexes
        DB::statement('CREATE INDEX idx_ads_user_id ON ads(user_id);');
        DB::statement('CREATE INDEX idx_ads_status ON ads(status);');
        DB::statement('CREATE INDEX idx_ads_location ON ads(governorate, city, area);');
        DB::statement('CREATE INDEX idx_ads_price ON ads(price);');
        DB::statement('CREATE INDEX idx_ads_priority_score ON ads(priority_score DESC);');
        DB::statement('CREATE INDEX idx_ads_created_at ON ads(created_at DESC);');
        DB::statement('CREATE INDEX idx_ads_published_at ON ads(published_at DESC);');
        DB::statement('CREATE INDEX idx_ads_expires_at ON ads(expires_at);');

        // Full-text search indexes
        DB::statement('CREATE INDEX idx_ads_title_gin ON ads USING gin(to_tsvector(\'arabic\', title));');
        DB::statement('CREATE INDEX idx_ads_description_gin ON ads USING gin(to_tsvector(\'arabic\', description));');

        // Spatial indexes
        DB::statement('CREATE INDEX idx_ads_location_gist ON ads USING gist(location);');
        DB::statement('CREATE INDEX idx_user_addresses_location_gist ON user_addresses USING gist(location);');

        // Message system indexes
        DB::statement('CREATE INDEX idx_conversations_buyer_seller ON conversations(buyer_id, seller_id);');
        DB::statement('CREATE INDEX idx_conversations_ad ON conversations(ad_id);');
        DB::statement('CREATE INDEX idx_messages_conversation_sent_at ON messages(conversation_id, sent_at DESC);');
        DB::statement('CREATE INDEX idx_messages_recipient_unread ON messages(recipient_id, is_read, sent_at DESC);');

        // Favorites and searches
        DB::statement('CREATE INDEX idx_favorites_user_ad ON favorites(user_id, ad_id);');
        DB::statement('CREATE INDEX idx_favorites_ad ON favorites(ad_id);');

        // Reviews and ratings
        DB::statement('CREATE INDEX idx_reviews_reviewee_rating ON reviews(reviewee_id, rating, created_at DESC);');
        DB::statement('CREATE INDEX idx_reviews_ad ON reviews(ad_id);');

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
        DB::statement('DROP INDEX IF EXISTS idx_reviews_ad;');
        DB::statement('DROP INDEX IF EXISTS idx_reviews_reviewee_rating;');
        DB::statement('DROP INDEX IF EXISTS idx_favorites_ad;');
        DB::statement('DROP INDEX IF EXISTS idx_favorites_user_ad;');
        DB::statement('DROP INDEX IF EXISTS idx_messages_recipient_unread;');
        DB::statement('DROP INDEX IF EXISTS idx_messages_conversation_sent_at;');
        DB::statement('DROP INDEX IF EXISTS idx_conversations_ad;');
        DB::statement('DROP INDEX IF EXISTS idx_conversations_buyer_seller;');
        DB::statement('DROP INDEX IF EXISTS idx_user_addresses_location_gist;');
        DB::statement('DROP INDEX IF EXISTS idx_ads_location_gist;');
        DB::statement('DROP INDEX IF EXISTS idx_ads_description_gin;');
        DB::statement('DROP INDEX IF EXISTS idx_ads_title_gin;');
        DB::statement('DROP INDEX IF EXISTS idx_ads_expires_at;');
        DB::statement('DROP INDEX IF EXISTS idx_ads_published_at;');
        DB::statement('DROP INDEX IF EXISTS idx_ads_created_at;');
        DB::statement('DROP INDEX IF EXISTS idx_ads_priority_score;');
        DB::statement('DROP INDEX IF EXISTS idx_ads_price;');
        DB::statement('DROP INDEX IF EXISTS idx_ads_location;');
        DB::statement('DROP INDEX IF EXISTS idx_ads_status;');
        DB::statement('DROP INDEX IF EXISTS idx_ads_user_id;');
        DB::statement('DROP INDEX IF EXISTS idx_users_created_at;');
        DB::statement('DROP INDEX IF EXISTS idx_users_account_status;');
        DB::statement('DROP INDEX IF EXISTS idx_users_phone;');
        DB::statement('DROP INDEX IF EXISTS idx_users_email;');
    }
};