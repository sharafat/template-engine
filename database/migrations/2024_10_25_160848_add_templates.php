<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->integer('school_id')->nullable();

            $table->string('name', 190);
            $table->string('templatable_type', 190);
            $table->string('category', 190);
            $table->string('type', 190)->nullable();
            $table->string('builder', 190);
            $table->json('settings');
            $table->json('custom_fields');
            $table->longText('content');
            $table->string('screenshot', 190)->nullable();
            $table->boolean('active')->default(1);

            $table->unsignedInteger('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();

            // Indexes
            $table->index('school_id', 'fk_templates_school_id');
            $table->index('created_by', 'fk_templates_created_by');
            $table->index('category', 'idx_templates_category');
            $table->index('type', 'idx_templates_type');
            $table->index('builder', 'idx_templates_builder');

            // Foreign key constraint
            $table->foreign('school_id', 'fk_templates_school_id')
                  ->references('id')
                  ->on('schools')
                  ->onDelete('restrict');
            $table->foreign('created_by', 'fk_templates_created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');
        });

        Schema::create('template_defaults', function (Blueprint $table) {
            $table->id();
            $table->integer('school_id');

            $table->string('category', 190);
            $table->string('type', 190)->nullable();
            $table->unsignedBigInteger('template_id');

            $table->integer('session_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('shift_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('section_id')->nullable();
            $table->string('group_name', 190)->nullable();
            $table->string('gender', 10)->nullable();
            $table->integer('tag_id')->nullable();

            $table->unsignedInteger('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();

            // Indexes
            $table->index('school_id', 'fk_template_defaults_school_id');
            $table->index('template_id', 'fk_template_defaults_template_id');
            $table->index('session_id', 'fk_template_defaults_session_id');
            $table->index('branch_id', 'fk_template_defaults_branch_id');
            $table->index('shift_id', 'fk_template_defaults_shift_id');
            $table->index('class_id', 'fk_template_defaults_class_id');
            $table->index('section_id', 'fk_template_defaults_section_id');
            $table->index('tag_id', 'fk_template_defaults_tag_id');
            $table->index('created_by', 'fk_template_defaults_created_by');

            // Foreign key constraint
            $table->foreign('school_id', 'fk_template_defaults_school_id')
                  ->references('id')
                  ->on('schools')
                  ->onDelete('restrict');
            $table->foreign('template_id', 'fk_template_defaults_template_id')
                  ->references('id')
                  ->on('templates')
                  ->onDelete('restrict');
            $table->foreign('session_id', 'fk_template_defaults_session_id')
                  ->references('id')
                  ->on('academic_sessions')
                  ->onDelete('restrict');
            $table->foreign('branch_id', 'fk_template_defaults_branch_id')
                  ->references('id')
                  ->on('branches')
                  ->onDelete('restrict');
            $table->foreign('shift_id', 'fk_template_defaults_shift_id')
                  ->references('id')
                  ->on('shifts')
                  ->onDelete('restrict');
            $table->foreign('class_id', 'fk_template_defaults_class_id')
                  ->references('id')
                  ->on('classes')
                  ->onDelete('restrict');
            $table->foreign('section_id', 'fk_template_defaults_section_id')
                  ->references('id')
                  ->on('sections')
                  ->onDelete('restrict');
            $table->foreign('tag_id', 'fk_template_defaults_tag_id')
                  ->references('id')
                  ->on('profile_tags')
                  ->onDelete('restrict');
            $table->foreign('created_by', 'fk_template_defaults_created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_defaults');
        Schema::dropIfExists('templates');
    }
};
