<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // юзеры
        Schema::table('users', function(Blueprint $table) {
            // $table->bigIncrements('id')->change();
            $table->renameColumn('name', 'full_name');
            $table->dropColumn(['email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at']);
        }); 

        // удаляем другие группы

        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');

        //группы
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
        });

        // участники групп
        Schema::create('users_groups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('group_id')
                ->constrained('groups')
                ->onDelete('cascade');

            // $table->unique(['user_id', 'group_id']);
        });

        // пост в группе
        Schema::create('post_in_group', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('group_id')
                ->constrained('groups')
                ->onDelete('cascade');
            
            $table->text('text');
            $table->timestamp('date_of_post', 0);

            $table->index('group_id');
            $table->index(['group_id', 'date_of_post']);
            
        });

        Schema::create('friends', function (Blueprint $table) {
            $table->id();   
            
            $table->foreignId('user1_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('user2_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->date('date_of_friendship');

            
            // $table->unique(['user1_id', 'user2_id']);
        });

        DB::statement('ALTER TABLE friends
                ADD CONSTRAINT friends_self_check CHECK (user1_id <> user2_id)');

        DB::statement('CREATE UNIQUE INDEX friends_pair_unique_idx
                ON friends ((LEAST(user1_id, user2_id)), (GREATEST(user1_id, user2_id)))');

        Schema::create('message', function (Blueprint $table) {
            $table->id();   
            
            $table->foreignId('user_from_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('user_to_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamp('date_of_message', 0);
            $table->text('text');

            $table->index('user_from_id');
            $table->index('user_to_id');
            $table->index(['user_from_id', 'user_to_id', 'date_of_message']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        
        if (Schema::hasTable('friends')) {
             DB::statement('ALTER TABLE friends DROP CONSTRAINT IF EXISTS friends_self_check');
            DB::statement('DROP INDEX IF EXISTS friends_pair_unique_idx');
        }
        
        Schema::dropIfExists('message');
        Schema::dropIfExists('post_in_group');
        Schema::dropIfExists('users_groups');
        Schema::dropIfExists('friends');
        Schema::dropIfExists('groups'); 

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'full_name')) {
                $table->renameColumn('full_name', 'name');
            }
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email', 255)->unique();
            }
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'password')) {
                $table->string('password', 255);
            }
            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }
            if (!Schema::hasColumns('users', ['created_at','updated_at'])) {
                $table->timestamps(); 
            }
        });
    }
};
