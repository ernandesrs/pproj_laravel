<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();

            $table->string("title", 52)->nullable(false);
            $table->string("subtitle", 135)->nullable(true);
            $table->foreignId("page_id");
            $table->string("alignment", 6)->nullable(false)->default("left");
            $table->string("type", 8)->nullable(false)->default("section");
            $table->string("ilustration")->nullable(true);
            $table->text("buttons")->nullable(true);
            $table->text("content")->nullable(true);
            $table->fullText(["title", "subtitle"]);

            $table->foreign("page_id")->references("id")->on("pages")->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
