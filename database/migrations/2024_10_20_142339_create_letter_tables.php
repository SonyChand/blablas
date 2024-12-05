<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('incoming_letters', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->longText('source_letter');
            $table->longText('addressed_to');
            $table->string('letter_number');
            $table->date('letter_date')->format('d-m-Y');
            $table->string('subject');
            $table->string('attachment')->nullable();
            $table->longText('forwarded_disposition')->nullable();
            $table->longText('file_path')->nullable();
            $table->string('operator_name');
            $table->timestamps();
        });

        Schema::create('outgoing_letters', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('letter_type');
            $table->string('letter_number')->nullable();
            $table->string('letter_nature')->nullable();
            $table->string('letter_subject')->nullable();
            $table->date('letter_date')->nullable();
            $table->longText('letter_destination')->nullable();
            $table->longText('to')->nullable();
            $table->text('letter_body')->nullable();
            $table->string('event_date_start')->nullable();
            $table->string('event_date_end')->nullable();
            $table->string('event_time_start')->nullable();
            $table->string('event_time_end')->nullable();
            $table->string('event_location')->nullable();
            $table->string('event_agenda')->nullable();
            $table->text('letter_closing')->nullable();
            $table->string('attachment')->nullable();
            $table->string('operator_name')->nullable();
            $table->longText('file_path')->nullable();
            $table->unsignedBigInteger('signed_by');
            $table->foreign('signed_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('recommendation_type');
            $table->string('recommendation_number');
            $table->string('basis_of_recommendation');
            $table->string('recommendation_consideration');
            $table->text('recommended_data');
            $table->string('recommendation_purpose');
            $table->text('recommendation_closing');
            $table->date('recommendation_date');
            $table->string('signed_by');
            $table->string('operator_name');
            $table->timestamps();
        });

        Schema::create('official_task_files', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('letter_type');
            $table->string('letter_number');
            $table->string('letter_reference');
            $table->date('letter_date');
            $table->text('assign');
            $table->text('to_implement');
            $table->text('letter_closing');
            $table->date('letter_creation_date');
            $table->string('signed_by');
            $table->string('attachment')->nullable();
            $table->string('operator_name');
            $table->timestamps();
        });

        Schema::create('command_letters', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('letter_type');
            $table->string('letter_number');
            $table->string('letter_reference');
            $table->string('consideration');
            $table->string('the_one_giving_orders');
            $table->string('giving_orders_to');
            $table->text('to_implement');
            $table->text('letter_closing');
            $table->date('letter_creation_date');
            $table->string('signed_by');
            $table->string('attachment')->nullable();
            $table->string('operator_name');
            $table->timestamps();
        });

        Schema::create('sppds', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('letter_type');
            $table->string('letter_number');
            $table->string('commitment_making_officer');
            $table->string('business_trip_executor');
            $table->string('purpose_of_business_trip');
            $table->string('means_of_transportation_used');
            $table->string('departure_place');
            $table->string('destination');
            $table->string('length_of_business_trip');
            $table->date('departure_date');
            $table->date('date_must_return');
            $table->string('place_of_issuance_of_sppd');
            $table->date('date_of_issuance_of_sppd');
            $table->date('sppd_creation_date');
            $table->string('operator_name');
            $table->timestamps();
        });

        Schema::create('delivery_notes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->date('letter_date');
            $table->string('letter_number');
            $table->string('letter_purpose');
            $table->text('sent_manuscript_goods');
            $table->integer('quantity');
            $table->text('information')->nullable();
            $table->string('sender_data');
            $table->string('recipient');
            $table->string('operator_name');
            $table->timestamps();
        });

        Schema::create('memos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('to');
            $table->string('from');
            $table->string('copy')->nullable();
            $table->date('date');
            $table->string('number');
            $table->string('subject');
            $table->text('content');
            $table->text('closing');
            $table->string('signer');
            $table->string('operator_name');
            $table->timestamps();
        });

        Schema::create('dispositions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('letter_id');
            $table->string('letter_number')->nullable();
            $table->string('letter_nature')->nullable();
            $table->string('agenda_number')->nullable();
            $table->string('from')->nullable();
            $table->string('type')->nullable(); // incoming or outgoing
            $table->longText('disposition_to')->nullable();
            $table->text('notes')->nullable();
            $table->date('disposition_date')->nullable();
            $table->unsignedBigInteger('signed_by')->nullable();
            $table->timestamps();

            $table->foreign('letter_id')->references('id')->on('incoming_letters')->onDelete('cascade');
            $table->foreign('signed_by')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_letters');
        Schema::dropIfExists('outgoing_letters');
        Schema::dropIfExists('recommendations');
        Schema::dropIfExists('official_task_files');
        Schema::dropIfExists('command_letters');
        Schema::dropIfExists('sppds');
        Schema::dropIfExists('delivery_notes');
        Schema::dropIfExists('memos');
        Schema::dropIfExists('dispositions');
    }
};
