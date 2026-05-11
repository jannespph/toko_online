<?php 
use Illuminate\Database\Migrations\Migration; 
use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Support\Facades\Schema; 
  
return new class extends Migration { 
    public function up(): void { 
        Schema::create('categories', function (Blueprint $table) { 
            $table->id(); 
            $table->string('name'); 
            $table->string('slug')->unique();       // ← URL-friendly, harus unik 
            $table->text('description')->nullable(); 
            $table->string('icon', 10)->nullable(); // ← emoji (max 10 char) 
            $table->boolean('is_active')->default(true); 
            $table->unsignedInteger('sort_order')->default(0); 
            $table->timestamps(); 
        }); 
    } 
    public function down(): void { 
        Schema::dropIfExists('categories'); 
    } 
}; 