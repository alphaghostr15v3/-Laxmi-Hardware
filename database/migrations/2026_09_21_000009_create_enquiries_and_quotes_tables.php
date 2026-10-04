<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('subject');
            $table->text('message');
            $table->string('status')->default('New'); // New, Read, Contacted, Closed
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('company')->nullable();
            $table->string('project_type')->nullable();
            $table->string('product_category')->nullable();
            $table->string('location')->nullable();
            $table->string('requirement')->nullable();
            $table->text('message')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('status')->default('New'); // New, Contacted, Quotation Sent, Converted, Closed
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
        Schema::dropIfExists('contacts');
    }
};
