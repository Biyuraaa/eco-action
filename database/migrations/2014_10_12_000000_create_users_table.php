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
            Schema::create('users', function (Blueprint $table) {
                $table->string('email', 255)->nullable(false)->primary();
                $table->string('name', 35)->nullable(false);
                $table->string('password', 255)->nullable(false);
                $table->enum('role', ['admin', 'user'])->default('user');
                $table->timestamp('created_at')->nullable(false)->useCurrent();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('users');
        }
    };
