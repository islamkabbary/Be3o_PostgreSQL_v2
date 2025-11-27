<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Function to update updated_at
        DB::unprepared('CREATE OR REPLACE FUNCTION update_updated_at_column() RETURNS TRIGGER AS $$ BEGIN NEW.updated_at = CURRENT_TIMESTAMP; RETURN NEW; END; $$ LANGUAGE plpgsql;');

        // Apply triggers
        DB::unprepared('CREATE OR REPLACE TRIGGER update_users_updated_at BEFORE UPDATE ON users FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_user_profiles_updated_at BEFORE UPDATE ON user_profiles FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_user_addresses_updated_at BEFORE UPDATE ON user_addresses FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_categories_updated_at BEFORE UPDATE ON categories FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_category_attributes_updated_at BEFORE UPDATE ON category_attributes FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_listings_updated_at BEFORE UPDATE ON listings FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_listing_attributes_updated_at BEFORE UPDATE ON listing_attributes FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_listing_images_updated_at BEFORE UPDATE ON listing_images FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_conversations_updated_at BEFORE UPDATE ON conversations FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_messages_updated_at BEFORE UPDATE ON messages FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_favorites_updated_at BEFORE UPDATE ON favorites FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        // تم حذف trigger لجدول saved_searches (Model محذوف)
        DB::unprepared('CREATE OR REPLACE TRIGGER update_reviews_updated_at BEFORE UPDATE ON reviews FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_review_votes_updated_at BEFORE UPDATE ON review_votes FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_notifications_updated_at BEFORE UPDATE ON notifications FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_admin_users_updated_at BEFORE UPDATE ON admin_users FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_subscription_plans_updated_at BEFORE UPDATE ON subscription_plans FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_subscriptions_updated_at BEFORE UPDATE ON subscriptions FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_settings_updated_at BEFORE UPDATE ON settings FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();');

        // Function to update favorite count
        DB::unprepared('CREATE OR REPLACE FUNCTION update_favorite_count() RETURNS TRIGGER AS $$ BEGIN IF TG_OP = \'INSERT\' THEN UPDATE listings SET favorite_count = favorite_count + 1 WHERE id = NEW.listing_id; RETURN NEW; ELSIF TG_OP = \'DELETE\' THEN UPDATE listings SET favorite_count = favorite_count - 1 WHERE id = OLD.listing_id; RETURN OLD; END IF; RETURN NULL; END; $$ LANGUAGE plpgsql;');
        DB::unprepared('CREATE OR REPLACE TRIGGER update_favorite_count_trigger AFTER INSERT OR DELETE ON favorites FOR EACH ROW EXECUTE FUNCTION update_favorite_count();');

        // Function to apply subscription features
        DB::unprepared('CREATE OR REPLACE FUNCTION apply_subscription_features() RETURNS TRIGGER AS $$ BEGIN IF NEW.status = \'active\' THEN UPDATE listings l SET priority_score = (SELECT priority_level FROM subscription_plans WHERE id = NEW.plan_id) WHERE l.user_id = NEW.user_id AND l.status = \'active\'; ELSIF NEW.status = \'expired\' OR NEW.status = \'cancelled\' THEN UPDATE listings l SET priority_score = 0 WHERE l.user_id = NEW.user_id AND l.status = \'active\'; END IF; RETURN NEW; END; $$ LANGUAGE plpgsql;');
        DB::unprepared('CREATE OR REPLACE TRIGGER apply_subscription_features_trigger AFTER UPDATE ON subscriptions FOR EACH ROW EXECUTE FUNCTION apply_subscription_features();');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_users_updated_at ON users;');
        // تكرار لكل trigger...
        DB::unprepared('DROP FUNCTION IF EXISTS update_updated_at_column;');
        DB::unprepared('DROP TRIGGER IF EXISTS update_favorite_count_trigger ON favorites;');
        DB::unprepared('DROP FUNCTION IF EXISTS update_favorite_count;');
        DB::unprepared('DROP TRIGGER IF EXISTS apply_subscription_features_trigger ON subscriptions;');
        DB::unprepared('DROP FUNCTION IF EXISTS apply_subscription_features;');
    }
};