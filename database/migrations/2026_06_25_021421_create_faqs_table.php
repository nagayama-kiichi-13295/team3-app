public function up(): void
{
    Schema::create('faqs', function (Blueprint $table) {
        $table->id();
        $table->string('keyword');
        $table->text('answer');
        $table->timestamps();
    });
}